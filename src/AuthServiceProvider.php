<?php

namespace LiraUi\Auth;

use Illuminate\Auth\Events\Registered as UserRegisteredEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;
use LiraUi\Auth\Actions\AuthenticateUserAction;
use LiraUi\Auth\Actions\ChangeUserPasswordAction;
use LiraUi\Auth\Actions\ConfirmTwoFactorAuthenticationAction;
use LiraUi\Auth\Actions\DeleteUserAction;
use LiraUi\Auth\Actions\DisableTwoFactorAuthenticationAction;
use LiraUi\Auth\Actions\EnableTwoFactorAuthenticationAction;
use LiraUi\Auth\Actions\InvalidateBrowserSessionAction;
use LiraUi\Auth\Actions\LogOutUserAction;
use LiraUi\Auth\Actions\RegisterUserAction;
use LiraUi\Auth\Actions\ResetUserPasswordAction;
use LiraUi\Auth\Actions\SendUserEmailVerificationAction;
use LiraUi\Auth\Actions\SendUserPasswordResetLinkAction;
use LiraUi\Auth\Actions\UpdateUserInformationAction;
use LiraUi\Auth\Actions\VerifyEmailAction;
use LiraUi\Auth\Actions\VerifyTwoFactorAuthenticationAction;
use LiraUi\Auth\Actions\VerifyTwoFactorRecoveryCodeAction;
use LiraUi\Auth\Contracts\AuthenticatesUser;
use LiraUi\Auth\Contracts\BrowserSessionInvalidated;
use LiraUi\Auth\Contracts\ChangesUserPassword;
use LiraUi\Auth\Contracts\ConfirmsTwoFactorAuthentication;
use LiraUi\Auth\Contracts\DeletesUser;
use LiraUi\Auth\Contracts\DisablesTwoFactorAuthentication;
use LiraUi\Auth\Contracts\EmailVerified;
use LiraUi\Auth\Contracts\EnablesTwoFactorAuthentication;
use LiraUi\Auth\Contracts\InvalidatesBrowserSession;
use LiraUi\Auth\Contracts\LogsOutUser;
use LiraUi\Auth\Contracts\RecoveryCodes;
use LiraUi\Auth\Contracts\RegistersUser;
use LiraUi\Auth\Contracts\ResetsUserPassword;
use LiraUi\Auth\Contracts\SendsUserEmailVerification;
use LiraUi\Auth\Contracts\SendsUserPasswordResetLink;
use LiraUi\Auth\Contracts\TwoFactorAuthenticationConfirmed;
use LiraUi\Auth\Contracts\TwoFactorAuthenticationDisabled;
use LiraUi\Auth\Contracts\TwoFactorAuthenticationEnabled;
use LiraUi\Auth\Contracts\TwoFactorRecoveryCodeVerified;
use LiraUi\Auth\Contracts\TwoFactorVerified;
use LiraUi\Auth\Contracts\UpdatesUserInformation;
use LiraUi\Auth\Contracts\UserAuthenticated;
use LiraUi\Auth\Contracts\UserEmailVerificationSent;
use LiraUi\Auth\Contracts\UserInformationUpdated;
use LiraUi\Auth\Contracts\UserLoggedOut;
use LiraUi\Auth\Contracts\UserPasswordChanged;
use LiraUi\Auth\Contracts\UserPasswordReset;
use LiraUi\Auth\Contracts\UserPasswordResetLinkSent;
use LiraUi\Auth\Contracts\UserRegistered;
use LiraUi\Auth\Contracts\VerifiesEmail;
use LiraUi\Auth\Contracts\VerifiesTwoFactorAuthentication;
use LiraUi\Auth\Contracts\VerifiesTwoFactorRecoveryCode;
use LiraUi\Auth\Http\Responses\AuthenticateUserResponse;
use LiraUi\Auth\Http\Responses\ChangeUserPasswordResponse;
use LiraUi\Auth\Http\Responses\ConfirmTwoFactorAuthenticationResponse;
use LiraUi\Auth\Http\Responses\DisableTwoFactorAuthenticationResponse;
use LiraUi\Auth\Http\Responses\EmailVerifiedResponse;
use LiraUi\Auth\Http\Responses\EnableTwoFactorAuthenticationResponse;
use LiraUi\Auth\Http\Responses\InvalidateBrowserSessionResponse;
use LiraUi\Auth\Http\Responses\LogOutUserResponse;
use LiraUi\Auth\Http\Responses\RecoveryCodesResponse;
use LiraUi\Auth\Http\Responses\RegisterUserResponse;
use LiraUi\Auth\Http\Responses\ResetUserPasswordResponse;
use LiraUi\Auth\Http\Responses\SendUserEmailVerificationResponse;
use LiraUi\Auth\Http\Responses\SendUserPasswordResetLinkResponse;
use LiraUi\Auth\Http\Responses\UpdateUserInformationResponse;
use LiraUi\Auth\Http\Responses\VerifyTwoFactorAuthenticationResponse;
use LiraUi\Auth\Http\Responses\VerifyTwoFactorRecoveryCodeResponse;
use LiraUi\Auth\Listeners\SendEmailVerificationNotification;
use LiraUi\Auth\Otp\Otp;
use LiraUi\Auth\Otp\OtpStore;
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
        $this->app->singleton(ConfirmsTwoFactorAuthentication::class, ConfirmTwoFactorAuthenticationAction::class);
        $this->app->singleton(DeletesUser::class, DeleteUserAction::class);
        $this->app->singleton(DisablesTwoFactorAuthentication::class, DisableTwoFactorAuthenticationAction::class);
        $this->app->singleton(EnablesTwoFactorAuthentication::class, EnableTwoFactorAuthenticationAction::class);
        $this->app->singleton(InvalidatesBrowserSession::class, InvalidateBrowserSessionAction::class);
        $this->app->singleton(LogsOutUser::class, LogOutUserAction::class);
        $this->app->singleton(RegistersUser::class, RegisterUserAction::class);
        $this->app->singleton(ResetsUserPassword::class, ResetUserPasswordAction::class);
        $this->app->singleton(SendsUserEmailVerification::class, SendUserEmailVerificationAction::class);
        $this->app->singleton(SendsUserPasswordResetLink::class, SendUserPasswordResetLinkAction::class);
        $this->app->singleton(UpdatesUserInformation::class, UpdateUserInformationAction::class);
        $this->app->singleton(VerifiesTwoFactorAuthentication::class, VerifyTwoFactorAuthenticationAction::class);
        $this->app->singleton(VerifiesTwoFactorRecoveryCode::class, VerifyTwoFactorRecoveryCodeAction::class);
        $this->app->singleton(VerifiesEmail::class, VerifyEmailAction::class);
        $this->app->singleton(ChangesUserPassword::class, ChangeUserPasswordAction::class);

        // Register response bindings
        $this->app->singleton(BrowserSessionInvalidated::class, InvalidateBrowserSessionResponse::class);
        $this->app->singleton(UserAuthenticated::class, AuthenticateUserResponse::class);
        $this->app->singleton(TwoFactorAuthenticationConfirmed::class, ConfirmTwoFactorAuthenticationResponse::class);
        $this->app->singleton(TwoFactorAuthenticationDisabled::class, DisableTwoFactorAuthenticationResponse::class);
        $this->app->singleton(TwoFactorAuthenticationEnabled::class, EnableTwoFactorAuthenticationResponse::class);
        $this->app->singleton(UserLoggedOut::class, LogOutUserResponse::class);
        $this->app->singleton(RecoveryCodes::class, RecoveryCodesResponse::class);
        $this->app->singleton(UserRegistered::class, RegisterUserResponse::class);
        $this->app->singleton(UserPasswordReset::class, ResetUserPasswordResponse::class);
        $this->app->singleton(UserEmailVerificationSent::class, SendUserEmailVerificationResponse::class);
        $this->app->singleton(EmailVerified::class, EmailVerifiedResponse::class);
        $this->app->singleton(UserPasswordResetLinkSent::class, SendUserPasswordResetLinkResponse::class);
        $this->app->singleton(UserInformationUpdated::class, UpdateUserInformationResponse::class);
        $this->app->singleton(TwoFactorVerified::class, VerifyTwoFactorAuthenticationResponse::class);
        $this->app->singleton(TwoFactorRecoveryCodeVerified::class, VerifyTwoFactorRecoveryCodeResponse::class);
        $this->app->singleton(UserPasswordChanged::class, ChangeUserPasswordResponse::class);

        // Register service bindings
        $this->app->singleton('liraui-auth-otp', function ($app) {
            return new Otp($app->make(OtpStore::class));
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
