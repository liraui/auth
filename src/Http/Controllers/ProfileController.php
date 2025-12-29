<?php

namespace LiraUi\Auth\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Jenssegers\Agent\Agent;
use LiraUi\Auth\Contracts\BrowserSessionInvalidated;
use LiraUi\Auth\Contracts\ChangesUserPassword;
use LiraUi\Auth\Contracts\ConfirmsTwoFactor;
use LiraUi\Auth\Contracts\DeletesUser;
use LiraUi\Auth\Contracts\DisablesTwoFactor;
use LiraUi\Auth\Contracts\EnablesTwoFactor;
use LiraUi\Auth\Contracts\InvalidatesBrowserSession;
use LiraUi\Auth\Contracts\PasswordChanged;
use LiraUi\Auth\Contracts\ProfileUpdated;
use LiraUi\Auth\Contracts\ShowRecoveryCodes;
use LiraUi\Auth\Contracts\TwoFactorConfirmed;
use LiraUi\Auth\Contracts\TwoFactorDisabled;
use LiraUi\Auth\Contracts\TwoFactorEnabled;
use LiraUi\Auth\Contracts\UpdatesProfile;
use LiraUi\Auth\Http\Requests\ChangePasswordRequest;
use LiraUi\Auth\Http\Requests\ConfirmTwoFactorRequest;
use LiraUi\Auth\Http\Requests\DeleteAccountRequest;
use LiraUi\Auth\Http\Requests\DisableTwoFactorRequest;
use LiraUi\Auth\Http\Requests\EnableTwoFactorRequest;
use LiraUi\Auth\Http\Requests\InvalidateBrowserSessionRequest;
use LiraUi\Auth\Http\Requests\ShowRecoveryCodesRequest;
use LiraUi\Auth\Http\Requests\UpdateProfileRequest;
use LiraUi\Auth\Otac\OtacStore;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected Agent $agent,
        protected OtacStore $otacStore
    ) {
        //
    }

    #[Get(
        uri: '/profile/settings',
        name: 'liraui-auth::profile.settings',
        middleware: ['web', 'auth', 'verified']
    )]
    public function showProfile(): InertiaResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) {
                /** @var string|null $userAgent */
                $userAgent = $session->user_agent;

                /** @var int $lastActivity */
                $lastActivity = $session->last_activity;

                $this->agent->setUserAgent($userAgent ?? '');

                return [
                    'id' => $session->id,
                    'agent' => [
                        'platform' => $this->agent->platform() ?: 'Unknown',
                        'browser' => $this->agent->browser() ?: 'Unknown',
                    ],
                    'ip_address' => $session->ip_address,
                    'is_current_device' => $session->id === session()->getId(),
                    'last_active' => Carbon::createFromTimestamp($lastActivity)->diffForHumans(),
                ];
            })
            ->values()
            ->toArray();

        $emailChanged = $this->otacStore->identifier('user:'.$user->id.':email-update')->retrieve();

        /** @var \Carbon\Carbon|null $emailChangeExpiresIn */
        $emailChangeExpiresIn = $emailChanged['expires'] ?? null;

        if ($emailChanged !== null) {
            assert(is_object($emailChanged['otac']) && property_exists($emailChanged['otac'], 'newEmail'));
        }

        return Inertia::render('liraui-auth::profile/settings', [
            'emailChangedTo' => [
                'newEmail' => $emailChanged['otac']->newEmail ?? null,
                'expiresIn' => $emailChangeExpiresIn?->diffForHumans(),
            ],
            'twoFactorEnabled' => ! is_null($user->two_factor_secret) && ! is_null($user->two_factor_confirmed_at),
            'sessions' => $sessions,
        ]);
    }

    #[Post(
        uri: '/profile/information',
        name: 'profile.information.update',
        middleware: ['web', 'auth', 'verified', 'throttle:10,1']
    )]
    public function updateProfile(UpdateProfileRequest $request, UpdatesProfile $updater): Response
    {
        $user = $updater->update($request);

        return app(ProfileUpdated::class)->toResponse($request);
    }

    #[Post(
        uri: '/profile/password',
        name: 'profile.password.update',
        middleware: ['web', 'auth']
    )]
    public function changePassword(ChangePasswordRequest $request, ChangesUserPassword $changer): Response
    {
        $changer->handle($request);

        return app(PasswordChanged::class)->toResponse($request);
    }

    #[Post(
        uri: '/profile/two-factor/enable',
        name: 'profile.two-factor.enable',
        middleware: ['web', 'auth', 'verified', 'throttle:5,1']
    )]
    public function enableTwoFactor(EnableTwoFactorRequest $request, EnablesTwoFactor $enabler): Response
    {
        $data = $enabler->enable($request);

        return app(TwoFactorEnabled::class)->toResponse($request, $data);
    }

    #[Post(
        uri: '/profile/two-factor/confirm',
        name: 'profile.two-factor.confirm',
        middleware: ['web', 'auth', 'verified', 'throttle:5,1']
    )]
    public function confirmTwoFactor(ConfirmTwoFactorRequest $request, ConfirmsTwoFactor $confirmer): Response
    {
        $recoveryCodes = $confirmer->confirm($request);

        return app(TwoFactorConfirmed::class)->toResponse($request, $recoveryCodes);
    }

    #[Post(
        uri: '/profile/two-factor/disable',
        name: 'profile.two-factor.disable',
        middleware: ['web', 'auth', 'verified', 'throttle:3,1']
    )]
    public function disableTwoFactor(DisableTwoFactorRequest $request, DisablesTwoFactor $disabler): Response
    {
        $disabler->disable($request);

        return app(TwoFactorDisabled::class)->toResponse($request);
    }

    #[Post(
        uri: '/profile/two-factor/recovery-codes/show',
        name: 'profile.two-factor.recovery-codes.show',
        middleware: ['web', 'auth', 'verified', 'throttle:6,1']
    )]
    public function showRecoveryCodes(ShowRecoveryCodesRequest $request): Response
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var string $decrypted */
        $decrypted = decrypt($user->two_factor_recovery_codes ?? '');

        /** @var array<int, mixed>|null $recoveryCodesData */
        $recoveryCodesData = json_decode($decrypted, true);

        if ($recoveryCodesData === null) {
            $recoveryCodes = [];
        } else {
            $recoveryCodes = array_map(fn ($code) => is_scalar($code) ? (string) $code : '', $recoveryCodesData);
        }

        return app(ShowRecoveryCodes::class)->toResponse($request, $recoveryCodes);
    }

    #[Delete(
        uri: '/profile/browser-sessions/{session_id}',
        name: 'profile.browser-sessions.invalidate',
        middleware: ['web', 'auth', 'verified', 'throttle:10,1']
    )]
    public function invalidateSession(InvalidateBrowserSessionRequest $request, string $sessionId, InvalidatesBrowserSession $invalidater): Response
    {
        $invalidater->invalidate($request, $sessionId);

        return app(BrowserSessionInvalidated::class)->toResponse($request);
    }

    #[Delete(
        uri: '/profile/account',
        name: 'profile.account.destroy',
        middleware: ['web', 'auth', 'verified', 'throttle:3,1']
    )]
    public function delete(DeleteAccountRequest $request, DeletesUser $deleter): RedirectResponse
    {
        $deleter->delete($request);

        return redirect('/');
    }
}
