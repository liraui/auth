<?php

namespace LiraUi\Auth\Actions;

use App\Models\User;
use Illuminate\Auth\Events\Registered as UserRegisteredEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use LiraUi\Auth\Contracts\RegistersUser;
use LiraUi\Auth\Http\Requests\RegisterRequest;

class RegisterUserAction implements RegistersUser
{
    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request): User
    {
        $validated = $request->validated();

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => null,
        ]);

        event(new UserRegisteredEvent($user));

        Auth::login($user);

        return $user;
    }
}
