<?php

use App\Models\User;
use Illuminate\Auth\Events\Login as UserLoggedInEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LiraUi\Auth\Listeners\RequireTwoFactorForPasskeyLogin;
use LiraUi\Auth\Tests\TestCase;

test('authenticated user can confirm password for passkeys', function () {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    $response = $this->post('/profile/passkeys/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();

    expect(session('auth.password_confirmed_at'))->not->toBeNull();
});

test('user can delete their own passkey', function () {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $passkey = DB::table('passkeys')->insertGetId([
        'user_id' => $user->id,
        'name' => 'My MacBook',
        'credential_id' => 'cred-abc123',
        'credential' => json_encode(['id' => 'cred-abc123', 'type' => 'public-key']),
        'last_used_at' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->actingAs($user)
        ->deleteJson("/profile/passkeys/{$passkey}", ['password' => 'password']);

    $response->assertOk();

    expect(DB::table('passkeys')->where('id', $passkey)->exists())->toBeFalse();
});

test('profile page includes passkeys in props', function () {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    DB::table('passkeys')->insert([
        'user_id' => $user->id,
        'name' => 'Touch ID',
        'credential_id' => 'cred-prop-test',
        'credential' => json_encode(['id' => 'cred-prop-test', 'type' => 'public-key']),
        'last_used_at' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($user);

    $response = $this->withHeader('X-Inertia', 'true')->get('/profile/settings');

    $response->assertOk()->assertJsonPath('props.passkeys.0.name', 'Touch ID');
});

test('passkey login requires two factor verification when enabled', function () {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'two_factor_secret' => encrypt('secret'),
        'two_factor_confirmed_at' => now(),
    ]);

    $request = Request::create('/passkeys/login', 'POST', [
    ], server: [
        'HTTP_ACCEPT' => 'application/json',
    ]);

    $request->setLaravelSession($this->app['session.store']);
    $request->session()->put('auth.two_factor.pending_id', 1);

    $request->setRouteResolver(fn () => new class
    {
        public function named(string $name): bool
        {
            return $name === 'passkey.login';
        }
    });

    app()->instance('request', $request);

    $this->actingAs($user);

    (new RequireTwoFactorForPasskeyLogin)->handle(new UserLoggedInEvent('web', $user, false));

    expect(session('auth.two_factor.pending_id'))->toBe($user->id);

    expect(session('auth.two_factor.remember'))->toBeFalse();

    expect(session('auth.two_factor.expires_at'))->not()->toBeNull();

    expect(Auth::guard('web')->check())->toBeFalse();
});
