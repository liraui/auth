<?php

use App\Models\User;
use PragmaRX\Google2FA\Google2FA;

test('user can enable two factor', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    $response = $this->post('/profile/two-factor/enable', [
        'password' => 'password',
    ]);

    $response->assertSessionHas('flash.qrCodeUrl');

    $response->assertSessionHas('flash.secret');

    return [$user, $response];
});

test('user can confirm two factor', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    $response = $this->post('/profile/two-factor/enable', [
        'password' => 'password',
    ]);

    $google2Fa = app(Google2FA::class);

    $secret = $response->getSession()->get('flash.secret');

    $code = $google2Fa->getCurrentOtp($secret);

    $response = $this->post('/profile/two-factor/confirm', [
        'code' => $code,
    ]);

    $response->assertSessionHas('flash.recoveryCodes');

    $this->assertNotNull($user->two_factor_secret);

    $this->assertNotNull($user->two_factor_recovery_codes);

    $this->assertNotNull($user->two_factor_confirmed_at);
});

test('user cannot confirm two factor with invalid code', function () {
    //
})->skip();

test('user can disable two factor', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'two_factor_secret' => encrypt('secret'),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        'two_factor_confirmed_at' => now(),
    ]);

    $this->actingAs($user);

    $response = $this->post('/profile/two-factor/disable', [
        'password' => 'password',
    ]);

    $response->assertSessionHas('flash', [
        'type' => 'success',
        'message' => 'Two-factor authentication has been disabled.',
    ]);

    $user->refresh();

    $this->assertNull($user->two_factor_secret);

    $this->assertNull($user->two_factor_recovery_codes);

    $this->assertNull($user->two_factor_confirmed_at);
});

test('user can see recovery codes', function () {
    $recoveryCodes = ['code1', 'code2', 'code3'];

    $user = User::factory()->create([
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'two_factor_secret' => encrypt('secret'),
        'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        'two_factor_confirmed_at' => now(),
    ]);

    $this->actingAs($user);

    $response = $this->post('/profile/two-factor/recovery-codes/show', [
        'password' => 'password',
    ]);

    $response->assertSessionHas('flash', [
        'type' => 'success',
        'message' => 'Recovery codes retrieved successfully.',
        'recoveryCodes' => $recoveryCodes,
    ]);
});
