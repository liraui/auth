<?php

use App\Models\User;
use Illuminate\Support\Facades\Event;
use LiraUi\Auth\Events\UserDeletedEvent;
use LiraUi\Auth\Tests\TestCase;

test('user can delete account', function () {
    /** @var TestCase $this */
    Event::fake();

    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $this->actingAs($user);

    $response = $this->delete('/profile/account', [
        'password' => 'password',
    ]);

    $response->assertRedirect('/');

    Event::assertDispatched(UserDeletedEvent::class);

    $this->assertGuest();

    $this->assertDatabaseMissing('users', [
        'email' => 'test@example.com',
    ]);
});
