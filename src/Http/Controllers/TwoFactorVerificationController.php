<?php

namespace LiraUi\Auth\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use LiraUi\Auth\Concerns\HandlesTwoFactorSessions;
use LiraUi\Auth\Contracts\TwoFactorRecoveryCodeVerified;
use LiraUi\Auth\Contracts\TwoFactorVerified;
use LiraUi\Auth\Contracts\VerifiesTwoFactor;
use LiraUi\Auth\Contracts\VerifiesTwoFactorRecoveryCode;
use LiraUi\Auth\Http\Requests\VerifyTwoFactorRecoveryCodeRequest;
use LiraUi\Auth\Http\Requests\VerifyTwoFactorRequest;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorVerificationController extends Controller
{
    use HandlesTwoFactorSessions;

    #[Get(
        uri: '/two-factor/verify',
        name: 'two-factor.verify',
        middleware: ['web']
    )]
    public function showTwoFactorChallenge(Request $request): InertiaResponse|RedirectResponse
    {
        if (! $this->hasPendingTwoFactorSession($request)) {
            return redirect()->route('auth.login');
        }

        if ($this->isTwoFactorSessionExpired($request)) {
            $this->clearTwoFactorSession($request);

            return redirect()->route('auth.login')
                ->with('status', 'Your two-factor authentication session has expired. Please log in again.');
        }

        return Inertia::render('liraui-auth::auth/verify-two-factor');
    }

    #[Post(
        uri: '/two-factor/verify',
        name: 'two-factor.verify.store',
        middleware: ['web', 'throttle:6,1']
    )]
    public function verifyTwoFactor(VerifyTwoFactorRequest $request, VerifiesTwoFactor $verifier): Response
    {
        $verifier->verify($request);

        return app(TwoFactorVerified::class)->toResponse($request);
    }

    #[Get(
        uri: '/two-factor/recovery',
        name: 'two-factor.recovery',
        middleware: ['web']
    )]
    public function showRecoveryCodeForm(Request $request): InertiaResponse|RedirectResponse
    {
        if (! $this->hasPendingTwoFactorSession($request)) {
            return redirect()->route('auth.login');
        }

        if ($this->isTwoFactorSessionExpired($request)) {
            $this->clearTwoFactorSession($request);

            return redirect()->route('auth.login')
                ->with('status', 'Your two-factor authentication session has expired. Please log in again.');
        }

        return Inertia::render('liraui-auth::auth/verify-recovery-code');
    }

    #[Post(
        uri: '/two-factor/recovery',
        name: 'two-factor.recovery.store',
        middleware: ['web', 'throttle:6,1']
    )]
    public function verifyRecoveryCode(VerifyTwoFactorRecoveryCodeRequest $request, VerifiesTwoFactorRecoveryCode $verifier): Response
    {
        $verifier->verify($request);

        return app(TwoFactorRecoveryCodeVerified::class)->toResponse($request);
    }
}
