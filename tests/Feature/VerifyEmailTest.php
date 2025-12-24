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

test('user cannot resend email verification notification if already verified', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    $response = $this->post('/auth/email/verification-notification');

    $response->assertSessionHasErrors('email');
});

test('user cannot verify email with invalid code', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user);

    $response = $this->post('/auth/email/verify', [
        'code' => '123456',
    ]);

    $response->assertSessionHasErrors('code');

    $this->assertNull($user->email_verified_at);
});

test('user cannot verify email if already verified', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    $response = $this->post('/auth/email/verify', [
        'code' => 'dummy',
    ]);

    $response->assertSessionHasErrors('code');
});

test('user can mark email as verified', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    expect($user->hasVerifiedEmail())->toBeFalse();

    $result = $user->markEmailAsVerified();

    expect($result)->toBeTrue();
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

test('user get email for verification', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    expect($user->getEmailForVerification())->toBe('test@example.com');
});

test('user cannot send email verification notification if already sent', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Notification::fake();

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $user->sendEmailVerificationNotification($user->email);

    Notification::assertSentTo(
        Notification::route('mail', $user->email),
        OtacNotification::class
    );

    $user->sendEmailVerificationNotification($user->email);

    Notification::assertSentTo(
        Notification::route('mail', $user->email),
        OtacNotification::class
    );
});
