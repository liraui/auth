<?php

namespace LiraUi\Auth;

use Illuminate\Auth\Events\Registered as UserRegisteredEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;
use LiraUi\Auth\Actions\AuthenticateUserAction;
use LiraUi\Auth\Actions\ChangeUserPasswordAction;
use LiraUi\Auth\Actions\ConfirmTwoFactorAction;
use LiraUi\Auth\Actions\DeleteUserAction;
use LiraUi\Auth\Actions\DisableTwoFactorAction;
use LiraUi\Auth\Actions\EnableTwoFactorAction;
use LiraUi\Auth\Actions\InvalidateBrowserSessionAction;
use LiraUi\Auth\Actions\LogOutUserAction;
use LiraUi\Auth\Actions\RegisterUserAction;
use LiraUi\Auth\Actions\ResetUserPasswordAction;
use LiraUi\Auth\Actions\SendEmailVerificationAction;
use LiraUi\Auth\Actions\SendPasswordResetLinkAction;
use LiraUi\Auth\Actions\UpdateProfileAction;
use LiraUi\Auth\Actions\VerifyEmailAction;
use LiraUi\Auth\Actions\VerifyTwoFactorAction;
use LiraUi\Auth\Actions\VerifyTwoFactorRecoveryCodeAction;
use LiraUi\Auth\Contracts\Authenticated;
use LiraUi\Auth\Contracts\AuthenticatesUser;
use LiraUi\Auth\Contracts\BrowserSessionInvalidated;
use LiraUi\Auth\Contracts\ChangesUserPassword;
use LiraUi\Auth\Contracts\ConfirmsTwoFactor;
use LiraUi\Auth\Contracts\DeletesUser;
use LiraUi\Auth\Contracts\DisablesTwoFactor;
use LiraUi\Auth\Contracts\EmailVerificationSent;
use LiraUi\Auth\Contracts\EnablesTwoFactor;
use LiraUi\Auth\Contracts\InvalidatesBrowserSession;
use LiraUi\Auth\Contracts\LoggedOut;
use LiraUi\Auth\Contracts\LogsOutUser;
use LiraUi\Auth\Contracts\PasswordChanged;
use LiraUi\Auth\Contracts\PasswordReset;
use LiraUi\Auth\Contracts\PasswordResetLinkSent;
use LiraUi\Auth\Contracts\ProfileUpdated;
use LiraUi\Auth\Contracts\Registered;
use LiraUi\Auth\Contracts\RegistersUser;
use LiraUi\Auth\Contracts\ResetsUserPassword;
use LiraUi\Auth\Contracts\SendsEmailVerification;
use LiraUi\Auth\Contracts\SendsPasswordResetLink;
use LiraUi\Auth\Contracts\ShowRecoveryCodes;
use LiraUi\Auth\Contracts\TwoFactorConfirmed;
use LiraUi\Auth\Contracts\TwoFactorDisabled;
use LiraUi\Auth\Contracts\TwoFactorEnabled;
use LiraUi\Auth\Contracts\TwoFactorRecoveryCodeVerified;
use LiraUi\Auth\Contracts\TwoFactorVerified;
use LiraUi\Auth\Contracts\UpdatesProfile;
use LiraUi\Auth\Contracts\VerifiedEmail;
use LiraUi\Auth\Contracts\VerifiesEmail;
use LiraUi\Auth\Contracts\VerifiesTwoFactor;
use LiraUi\Auth\Contracts\VerifiesTwoFactorRecoveryCode;
use LiraUi\Auth\Http\Responses\AuthenticateUserResponse;
use LiraUi\Auth\Http\Responses\ChangeUserPasswordResponse;
use LiraUi\Auth\Http\Responses\ConfirmTwoFactorResponse;
use LiraUi\Auth\Http\Responses\DisableTwoFactorResponse;
use LiraUi\Auth\Http\Responses\EmailVerifiedResponse;
use LiraUi\Auth\Http\Responses\EnableTwoFactorResponse;
use LiraUi\Auth\Http\Responses\InvalidateBrowserSessionResponse;
use LiraUi\Auth\Http\Responses\LogOutUserResponse;
use LiraUi\Auth\Http\Responses\RecoveryCodesResponse;
use LiraUi\Auth\Http\Responses\RegisterUserResponse;
use LiraUi\Auth\Http\Responses\ResetUserPasswordResponse;
use LiraUi\Auth\Http\Responses\SendEmailVerificationResponse;
use LiraUi\Auth\Http\Responses\SendPasswordResetLinkResponse;
use LiraUi\Auth\Http\Responses\UpdateProfileResponse;
use LiraUi\Auth\Http\Responses\VerifyTwoFactorRecoveryCodeResponse;
use LiraUi\Auth\Http\Responses\VerifyTwoFactorResponse;
use LiraUi\Auth\Listeners\SendEmailVerificationNotification;
use LiraUi\Auth\Otac\Otac;
use LiraUi\Auth\Otac\OtacStore;
use PragmaRX\Google2FA\Google2FA;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge config from the package
        $this->mergeConfigFrom(__DIR__.'/../config/auth.php', 'liraui.auth');

        // Register action bindings
        $this->app->singleton(AuthenticatesUser::class, AuthenticateUserAction::class);
        $this->app->singleton(ConfirmsTwoFactor::class, ConfirmTwoFactorAction::class);
        $this->app->singleton(DeletesUser::class, DeleteUserAction::class);
        $this->app->singleton(DisablesTwoFactor::class, DisableTwoFactorAction::class);
        $this->app->singleton(EnablesTwoFactor::class, EnableTwoFactorAction::class);
        $this->app->singleton(InvalidatesBrowserSession::class, InvalidateBrowserSessionAction::class);
        $this->app->singleton(LogsOutUser::class, LogOutUserAction::class);
        $this->app->singleton(RegistersUser::class, RegisterUserAction::class);
        $this->app->singleton(ResetsUserPassword::class, ResetUserPasswordAction::class);
        $this->app->singleton(SendsEmailVerification::class, SendEmailVerificationAction::class);
        $this->app->singleton(SendsPasswordResetLink::class, SendPasswordResetLinkAction::class);
        $this->app->singleton(UpdatesProfile::class, UpdateProfileAction::class);
        $this->app->singleton(VerifiesTwoFactor::class, VerifyTwoFactorAction::class);
        $this->app->singleton(VerifiesTwoFactorRecoveryCode::class, VerifyTwoFactorRecoveryCodeAction::class);
        $this->app->singleton(VerifiesEmail::class, VerifyEmailAction::class);
        $this->app->singleton(ChangesUserPassword::class, ChangeUserPasswordAction::class);

        // Register response bindings
        $this->app->singleton(BrowserSessionInvalidated::class, InvalidateBrowserSessionResponse::class);
        $this->app->singleton(Authenticated::class, AuthenticateUserResponse::class);
        $this->app->singleton(TwoFactorConfirmed::class, ConfirmTwoFactorResponse::class);
        $this->app->singleton(TwoFactorDisabled::class, DisableTwoFactorResponse::class);
        $this->app->singleton(TwoFactorEnabled::class, EnableTwoFactorResponse::class);
        $this->app->singleton(LoggedOut::class, LogOutUserResponse::class);
        $this->app->singleton(ShowRecoveryCodes::class, RecoveryCodesResponse::class);
        $this->app->singleton(Registered::class, RegisterUserResponse::class);
        $this->app->singleton(PasswordReset::class, ResetUserPasswordResponse::class);
        $this->app->singleton(EmailVerificationSent::class, SendEmailVerificationResponse::class);
        $this->app->singleton(VerifiedEmail::class, EmailVerifiedResponse::class);
        $this->app->singleton(PasswordResetLinkSent::class, SendPasswordResetLinkResponse::class);
        $this->app->singleton(ProfileUpdated::class, UpdateProfileResponse::class);
        $this->app->singleton(TwoFactorVerified::class, VerifyTwoFactorResponse::class);
        $this->app->singleton(TwoFactorRecoveryCodeVerified::class, VerifyTwoFactorRecoveryCodeResponse::class);
        $this->app->singleton(PasswordChanged::class, ChangeUserPasswordResponse::class);

        // Register service bindings
        $this->app->singleton('liraui-auth-otac', function ($app) {
            return new Otac($app->make(OtacStore::class));
        });
        $this->app->singleton(Agent::class, function () {
            return new Agent;
        });
        $this->app->singleton(Google2FA::class, function () {
            return new Google2FA;
        });
    }

    /**
     * Register the service provider.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/auth.php' => config_path('liraui-auth.php'),
        ], 'liraui-auth-config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'liraui-auth-migrations');

        $this->registerEventListeners();
    }

    /**
     * Register event listeners based on configuration.
     */
    protected function registerEventListeners(): void
    {
        Event::listen(
            UserRegisteredEvent::class,
            SendEmailVerificationNotification::class,
        );
    }
}
