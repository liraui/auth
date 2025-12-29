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
        /** @var string $password */
        $password = $request->input('password');

        /** @var User $user */
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($password),
            'email_verified_at' => null,
        ]);

        event(new UserRegisteredEvent($user));

        Auth::login($user);

        return $user;
    }
}
