<?php

namespace LiraUi\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use LiraUi\Auth\Contracts\Authenticated;
use LiraUi\Auth\Contracts\AuthenticatesUser;
use LiraUi\Auth\Contracts\LoggedOut;
use LiraUi\Auth\Contracts\LogsOutUser;
use LiraUi\Auth\Contracts\PasswordReset;
use LiraUi\Auth\Contracts\PasswordResetLinkSent;
use LiraUi\Auth\Contracts\Registered;
use LiraUi\Auth\Contracts\RegistersUser;
use LiraUi\Auth\Contracts\ResetsUserPassword;
use LiraUi\Auth\Contracts\SendsPasswordResetLink;
use LiraUi\Auth\Http\Requests\LoginRequest;
use LiraUi\Auth\Http\Requests\LogoutRequest;
use LiraUi\Auth\Http\Requests\RegisterRequest;
use LiraUi\Auth\Http\Requests\ResetPasswordRequest;
use LiraUi\Auth\Http\Requests\SendPasswordResetLinkRequest;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    #[Get(
        uri: '/auth/login',
        name: 'auth.login',
        middleware: ['web', 'guest']
    )]
    public function showLoginForm(): InertiaResponse
    {
        return Inertia::render('liraui-auth::auth/login');
    }

    #[Post(
        uri: '/auth/login',
        name: 'auth.login.attempt',
        middleware: ['web', 'guest']
    )]
    public function login(LoginRequest $request, AuthenticatesUser $authenticator): Response
    {
        $authenticator->handle($request);

        return app(Authenticated::class)->toResponse($request);
    }

    #[Post(
        uri: '/auth/logout',
        name: 'auth.logout',
        middleware: ['web', 'auth']
    )]
    public function logout(LogoutRequest $request, LogsOutUser $logger): Response
    {
        $logger->handle($request);

        return app(LoggedOut::class)->toResponse($request);
    }

    #[Get(
        uri: '/auth/register',
        name: 'auth.register',
        middleware: ['web', 'guest']
    )]
    public function showRegistrationForm(): InertiaResponse
    {
        return Inertia::render('liraui-auth::auth/register');
    }

    #[Post(
        uri: '/auth/register',
        name: 'auth.register.submit',
        middleware: ['web', 'guest', 'throttle:3,1']
    )]
    public function register(RegisterRequest $request, RegistersUser $registrar): Response
    {
        $user = $registrar->register($request);

        return app(Registered::class)->toResponse($request);
    }

    #[Get(
        uri: '/auth/forgot-password',
        name: 'auth.forgot-password',
        middleware: ['web', 'guest']
    )]
    public function showForgotPasswordForm(Request $request): InertiaResponse
    {
        return Inertia::render('liraui-auth::auth/forgot-password', [
            'status' => $request->session()->get('status'),
        ]);
    }

    #[Post(
        uri: '/auth/forgot-password',
        name: 'auth.forgot-password.submit',
        middleware: ['web', 'guest', 'throttle:5,1']
    )]
    public function sendPasswordResetLink(SendPasswordResetLinkRequest $request, SendsPasswordResetLink $sender): Response
    {
        $status = $sender->send($request);

        return app(PasswordResetLinkSent::class)->toResponse($request);
    }

    #[Get(
        uri: '/auth/reset-password/{token}',
        name: 'password.reset',
        middleware: ['web', 'guest']
    )]
    public function showResetPasswordForm(Request $request, string $token): InertiaResponse
    {
        return Inertia::render('liraui-auth::auth/reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    #[Post(
        uri: '/auth/reset-password',
        name: 'password.update',
        middleware: ['web', 'guest', 'throttle:5,1']
    )]
    public function resetPassword(ResetPasswordRequest $request, ResetsUserPassword $resetter): Response
    {
        $status = $resetter->reset($request);

        return app(PasswordReset::class)->toResponse($request);
    }
}
