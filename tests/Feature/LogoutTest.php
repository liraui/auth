<?php

use App\Models\User;

test('user can logout when authenticated', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $this->actingAs($user);

    $response = $this->post('/auth/logout');

    $response->assertRedirect('/auth/login');

    $this->assertGuest();
});

test('user can logout with json response', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'first_name' => 'Test',
        'last_name' => 'User',
    ]);

    $this->actingAs($user);

    $response = $this->postJson('/auth/logout');

    $response->assertJson([
        'type' => 'success',
        'message' => 'You have been logged out successfully.',
    ]);

    $this->assertGuest();
});
