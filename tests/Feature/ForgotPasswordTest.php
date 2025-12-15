<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use LiraUi\Auth\Events\PasswordResetLinkSentEvent;

test('user can request password reset with valid credentials', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Event::fake();
    Notification::fake();

    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $response = $this->post('/auth/forgot-password', [
        'email' => 'test@example.com',
    ]);

    $response->assertStatus(302);

    $response->assertSessionHasNoErrors();

    Event::assertDispatched(PasswordResetLinkSentEvent::class, function ($event) {
        return $event->email === 'test@example.com';
    });

    Notification::assertSentTo($user, ResetPassword::class);

    return [$user, Notification::sent($user, ResetPassword::class)->first()];
});

test('user cannot request password reset with invalid credentials', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Event::fake();

    Notification::fake();

    $response = $this->post('/auth/forgot-password', [
        'email' => 'test2@example.com',
    ]);

    $response->assertStatus(302);

    $response->assertSessionHasNoErrors();

    Event::assertNotDispatched(PasswordResetLinkSentEvent::class);

    Notification::assertNothingSent();
});

test('user can throttle password reset requests', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Event::fake();

    Notification::fake();

    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $response = $this->post('/auth/forgot-password', [
        'email' => 'test@example.com',
    ]);

    $response = $this->post('/auth/forgot-password', [
        'email' => 'test@example.com',
    ]);

    $response->assertStatus(302);

    $response->assertSessionHasErrors('email');

    Event::assertDispatched(PasswordResetLinkSentEvent::class, 1);

    Notification::assertSentTo($user, ResetPassword::class, 1);
});
