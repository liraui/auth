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
