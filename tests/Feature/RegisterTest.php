<?php

use Illuminate\Auth\Events\Registered as UserRegisteredEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

test('user can register with valid data', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Event::fake();

    Notification::fake();

    $response = $this->post('/auth/register', [
        'first_name' => 'Test',
        'last_name' => 'Yser',
        'email' => 'test@example.com',
        'password' => '#N3wP@sswordI5Gre4t',
        'password_confirmation' => '#N3wP@sswordI5Gre4t',
        'terms' => 'on',
    ]);

    $response->assertRedirect(config('liraui.auth.redirects.verify_email', 'verification.notice'));

    $response->assertSessionHasNoErrors();

    Event::assertDispatched(UserRegisteredEvent::class);
})->skip();
