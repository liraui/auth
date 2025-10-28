<?php

namespace LiraUi\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use LiraUi\Auth\Contracts\AuthenticatesUser;
use LiraUi\Auth\Contracts\LogsOutUser;
use LiraUi\Auth\Contracts\RegistersUser;
use LiraUi\Auth\Contracts\ResetsUserPassword;
use LiraUi\Auth\Contracts\SendsUserPasswordResetLink;
use LiraUi\Auth\Contracts\UserAuthenticated;
use LiraUi\Auth\Contracts\UserLoggedOut;
use LiraUi\Auth\Contracts\UserPasswordReset;
use LiraUi\Auth\Contracts\UserPasswordResetLinkSent;
use LiraUi\Auth\Contracts\UserRegistered;
use LiraUi\Auth\Http\Requests\ForgotPasswordRequest;
use LiraUi\Auth\Http\Requests\LoginRequest;
use LiraUi\Auth\Http\Requests\LogoutRequest;
use LiraUi\Auth\Http\Requests\RegisterRequest;
use LiraUi\Auth\Http\Requests\ResetPasswordRequest;
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
    public function showLogin(): InertiaResponse
    {
        return Inertia::render('liraui-auth::login');
    }

    #[Post(
        uri: '/auth/login',
        name: 'auth.login.attempt',
        middleware: ['web', 'guest']
    )]
    public function login(LoginRequest $request, AuthenticatesUser $authenticator): Response
    {
        $authenticator->handle($request);

        return app(UserAuthenticated::class)->toResponse($request);
    }

    #[Post(
        uri: '/auth/logout',
        name: 'auth.logout',
        middleware: ['web', 'auth']
    )]
    public function logout(LogoutRequest $request, LogsOutUser $logger): Response
    {
        $logger->handle($request);

        return app(UserLoggedOut::class)->toResponse($request);
    }

    #[Get(
        uri: '/auth/register',
        name: 'auth.register',
        middleware: ['web', 'guest']
    )]
    public function showRegister(): InertiaResponse
    {
        return Inertia::render('liraui-auth::register');
    }

    #[Post(
        uri: '/auth/register',
        name: 'auth.register.submit',
        middleware: ['web', 'guest', 'throttle:3,1']
    )]
    public function register(RegisterRequest $request, RegistersUser $registrar): Response
    {
        $user = $registrar->register($request);

        return app(UserRegistered::class)->toResponse($request);
    }

    #[Get(
        uri: '/auth/forgot-password',
        name: 'auth.forgot-password',
        middleware: ['web', 'guest']
    )]
    public function showForgotPassword(Request $request): InertiaResponse
    {
        return Inertia::render('liraui-auth::forgot-password', [
            'status' => $request->session()->get('status'),
        ]);
    }

    #[Post(
        uri: '/auth/forgot-password',
        name: 'auth.forgot-password.submit',
        middleware: ['web', 'guest', 'throttle:5,1']
    )]
    public function forgotPassword(ForgotPasswordRequest $request, SendsUserPasswordResetLink $sender): Response
    {
        $status = $sender->send($request);

        return app(UserPasswordResetLinkSent::class)->toResponse($request);
    }

    #[Get(
        uri: '/auth/reset-password/{token}',
        name: 'password.reset',
        middleware: ['web', 'guest']
    )]
    public function showResetPassword(Request $request, string $token): InertiaResponse
    {
        return Inertia::render('liraui-auth::reset-password', [
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

        return app(UserPasswordReset::class)->toResponse($request);
    }
}
