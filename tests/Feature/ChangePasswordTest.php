<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('user can change password', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $this->actingAs($user);

    $response = $this->post('/profile/password', [
        'current_password' => 'password',
        'password' => '#N3wP@sswordI5Gre4t',
        'password_confirmation' => '#N3wP@sswordI5Gre4t',
    ]);

    $response->assertSessionHas('flash', [
        'type' => 'success',
        'message' => 'Password has been changed successfully.',
    ]);

    $user->refresh();

    expect(Hash::check('#N3wP@sswordI5Gre4t', $user->password))->toBeTrue();
});

test('user cannot change password with wrong current password', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $this->actingAs($user);

    $response = $this->post('/profile/password', [
        'current_password' => 'wrongpassword',
        'password' => '#N3wP@sswordI5Gre4t',
        'password_confirmation' => '#N3wP@sswordI5Gre4t',
    ]);

    $response->assertSessionHasErrors('current_password');

    $user->refresh();

    expect(Hash::check('password', $user->password))->toBeTrue();
});

test('user cannot change password with invalid new password', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $this->actingAs($user);

    $response = $this->post('/profile/password', [
        'current_password' => 'password',
        'password' => 'short',
        'password_confirmation' => 'short',
    ]);

    $response->assertSessionHasErrors('password');

    $user->refresh();

    expect(Hash::check('password', $user->password))->toBeTrue();
});
