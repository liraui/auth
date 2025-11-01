<?php

namespace LiraUi\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use LiraUi\Auth\Contracts\VerifiedEmail;
use LiraUi\Auth\Contracts\SendsUserEmailVerification;
use LiraUi\Auth\Contracts\EmailVerificationSent;
use LiraUi\Auth\Contracts\VerifiesEmail;
use LiraUi\Auth\Http\Requests\SendUserEmailVerificationRequest;
use LiraUi\Auth\Http\Requests\VerifyEmailRequest;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationController extends Controller
{
    #[Get(
        uri: '/auth/verify-email',
        name: 'verification.notice',
        middleware: ['web', 'auth']
    )]
    public function showVerificationNotice(Request $request): InertiaResponse|Response
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        return Inertia::render('liraui-auth::verify-email', [
            'email' => $request->user()->email,
            'status' => session('status'),
        ]);
    }

    #[Post(
        uri: '/auth/email/verify',
        name: 'verification.verify',
        middleware: ['web', 'auth', 'throttle:6,1']
    )]
    public function verifyEmail(VerifyEmailRequest $request, VerifiesEmail $verifier): Response
    {
        $verifier->verify($request);

        return app(VerifiedEmail::class)->toResponse($request);
    }

    #[Post(
        uri: '/auth/email/verification-notification',
        name: 'verification.send',
        middleware: ['web', 'auth', 'throttle:6,1']
    )]
    public function resendVerification(SendUserEmailVerificationRequest $request, SendsUserEmailVerification $sender): Response
    {
        $sender->send($request);

        return app(EmailVerificationSent::class)->toResponse($request);
    }
}
