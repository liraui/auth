<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use LiraUi\Auth\Notifications\OtacNotification;

test('user can verify email with valid hash', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Notification::fake();

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $user->sendEmailVerificationNotification($user->email);

    $this->actingAs($user);

    Notification::assertSentTo(
        Notification::route('mail', $user->email),
        OtacNotification::class,
        function ($notification) {
            $response = $this->post('/auth/email/verify', [
                'code' => $notification->data['code'],
            ]);

            $response->assertSessionHas('flash', [
                'type' => 'success',
                'message' => 'Email has been verified successfully.',
            ]);

            return true;
        }
    );

    $user->refresh();

    expect($user->hasVerifiedEmail())->toBeTrue();
});

test('user can resend email verification notification', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Notification::fake();

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user);

    $response = $this->post('/auth/email/verification-notification');

    $response->assertSessionHas('flash', [
        'type' => 'success',
        'message' => 'An email verification link has been sent to your email address.',
    ]);

    Notification::assertSentTo(
        Notification::route('mail', $user->email),
        OtacNotification::class,
    );
});
