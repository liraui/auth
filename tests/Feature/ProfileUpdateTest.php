<?php

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use LiraUi\Auth\Events\EmailVerificationSentEvent;
use LiraUi\Auth\Events\ProfileUpdatedEvent;
use LiraUi\Auth\Notifications\OtacNotification;

test('user can update profile information without email change', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Event::fake();
    Notification::fake();

    $user = User::factory()->create([
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
    ]);

    $this->actingAs($user);

    $response = $this->post('/profile/information', [
        'first_name' => 'Ahsan',
        'last_name' => 'Zia',
        'email' => 'test@example.com',
    ]);

    $response->assertRedirect();

    $response->assertSessionHas('flash', [
        'type' => 'success',
        'message' => 'Profile information updated successfully',
    ]);

    Event::assertDispatched(ProfileUpdatedEvent::class);

    Event::assertNotDispatched(EmailVerificationSentEvent::class);

    Notification::assertNothingSent();

    $user->refresh();

    expect($user->first_name)->toBe('Ahsan');

    expect($user->last_name)->toBe('Zia');

    expect($user->email)->toBe('test@example.com');
});

test('user can update profile information with email change', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    Event::fake();
    Notification::fake();

    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $this->actingAs($user);

    $response = $this->post('/profile/information', [
        'first_name' => 'Ahsan',
        'last_name' => 'Zia',
        'email' => 'ahsan@liraui.com',
    ]);

    $response->assertRedirect();

    $response->assertSessionHas('flash', [
        'type' => 'success',
        'message' => 'Profile information updated successfully',
    ]);

    Event::assertDispatched(ProfileUpdatedEvent::class);

    Event::assertDispatched(EmailVerificationSentEvent::class);

    Notification::assertSentTo(
        Notification::route('mail', $user->email),
        OtacNotification::class
    );

    $user->refresh();

    expect($user->first_name)->toBe('Ahsan');

    expect($user->last_name)->toBe('Zia');

    expect($user->email)->not()->toBe('ahsan@liraui.com');
});
