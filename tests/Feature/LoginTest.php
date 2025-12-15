<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('user can login with valid credentials', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post('/auth/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(config('liraui.auth.redirects.home', 'dashboard'));

    $this->assertAuthenticated();
});

test('user cannot login with invalid credentials', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post('/auth/login', [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertRedirect();

    $response->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('user can login with remember me', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $response = $this->post('/auth/login', [
        'email' => 'test@example.com',
        'password' => 'password',
        'remember_me' => 'on',
    ]);

    $cookies = $response->headers->getCookies();

    $response->assertRedirect(config('liraui.auth.redirects.home', 'dashboard'));

    $this->assertAuthenticatedAs($user);

    $this->assertNotEmpty(
        collect($cookies)->first(fn ($cookie) => str_starts_with($cookie->getName(), 'remember_web'))
    );
});
