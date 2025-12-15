<?php

use App\Models\User;
use PragmaRX\Google2FA\Google2FA;

test('user can verify two-factor authentication with valid code', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $google2fa = new Google2FA;

    $secret = $google2fa->generateSecretKey();

    $user = User::factory()->create([
        'email' => 'test@example.com',
        'two_factor_secret' => encrypt($secret),
        'two_factor_confirmed_at' => now(),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
    ]);

    $response = $this->post('/auth/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect('/two-factor/verify');

    $this->assertGuest();

    $validCode = $google2fa->getCurrentOtp($secret);

    $response = $this->post('/two-factor/verify', [
        'code' => $validCode,
    ]);

    $response->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($user);
});

test('user can verify two-factor authentication with recovery code', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'two_factor_secret' => encrypt('secret'),
        'two_factor_confirmed_at' => now(),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
    ]);

    $response = $this->post('/auth/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect('/two-factor/verify');

    $this->assertGuest();

    $response = $this->post('/two-factor/recovery', [
        'recovery_code' => 'code1',
    ]);

    $this->assertAuthenticatedAs($user);

    $user->refresh();

    $codes = json_decode(decrypt($user->two_factor_recovery_codes), true);

    expect($codes)->not()->toContain('code1');

    expect($codes)->toContain('code2');
});
