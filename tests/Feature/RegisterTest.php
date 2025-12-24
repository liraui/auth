<?php

use Illuminate\Auth\Events\Registered as UserRegisteredEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use LiraUi\Auth\Notifications\OtacNotification;

test('user can register with valid data', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Event::fake();
    Notification::fake();

    $response = $this->post('/auth/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'password' => '#N3wP@sswordI5Gre4t',
        'password_confirmation' => '#N3wP@sswordI5Gre4t',
        'terms' => 'on',
    ]);

    $response->assertRedirect('/auth/verify-email');

    $response->assertSessionHasNoErrors();

    Event::assertDispatched(UserRegisteredEvent::class);
});

test('user can register with json response', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Event::fake();
    Notification::fake();

    $response = $this->postJson('/auth/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'password' => '#N3wP@sswordI5Gre4t',
        'password_confirmation' => '#N3wP@sswordI5Gre4t',
        'terms' => 'on',
    ]);

    $response->assertJson([
        'type' => 'success',
        'message' => 'Your account has been created, please verify your email address.',
    ]);

    $response->assertSessionHasNoErrors();

    Event::assertDispatched(UserRegisteredEvent::class);
});

test('listener sends email verification notification on user registration', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Notification::fake();

    $user = \App\Models\User::factory()->create([
        'email_verified_at' => null,
    ]);

    event(new UserRegisteredEvent($user));

    Notification::assertSentTo(
        Notification::route('mail', $user->email),
        OtacNotification::class
    );
});

test('listener does not send email verification notification if user is already verified', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Notification::fake();

    $user = \App\Models\User::factory()->create([
        'email_verified_at' => now(),
    ]);

    event(new UserRegisteredEvent($user));

    Notification::assertNothingSent();
});
