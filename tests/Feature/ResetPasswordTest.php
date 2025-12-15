<?php

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset as PasswordResetEvent;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

test('user can reset password with valid link', function () {
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

    Notification::assertSentTo($user, ResetPassword::class);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($response, $user) {
        $response = $this->post('/auth/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => '#N3wP@sswordI5Gre4t',
            'password_confirmation' => '#N3wP@sswordI5Gre4t',
        ]);

        Event::assertDispatched(PasswordResetEvent::class);

        $response->assertRedirect('/auth/login');

        return true;
    });

    $this->assertCredentials([
        'email' => $user->email,
        'password' => '#N3wP@sswordI5Gre4t',
    ]);
});
