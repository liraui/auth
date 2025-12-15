<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

test('user can invalidate a browser session', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    $sessionId = Str::uuid()->toString();

    DB::table('sessions')->insert([
        'id' => $sessionId,
        'user_id' => $user->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
        'payload' => 'test',
        'last_activity' => time(),
    ]);

    expect(DB::table('sessions')->where('id', $sessionId)->exists())->toBeTrue();

    $response = $this->delete("/profile/browser-sessions/{$sessionId}", [
        'password' => 'password',
    ]);

    $response->assertSessionHas('flash', [
        'type' => 'success',
        'message' => 'Session has been invalidated.',
    ]);

    expect(DB::table('sessions')->where('id', $sessionId)->exists())->toBeFalse();
});

test('user cannot invalidate session with wrong password', function () {
    /** @var \LiraUi\Auth\Tests\TestCase $this */
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    $sessionId = Str::uuid()->toString();

    DB::table('sessions')->insert([
        'id' => $sessionId,
        'user_id' => $user->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
        'payload' => 'test',
        'last_activity' => time(),
    ]);

    $response = $this->delete("/profile/browser-sessions/{$sessionId}", [
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors('password');

    expect(DB::table('sessions')->where('id', $sessionId)->exists())->toBeTrue();
});
