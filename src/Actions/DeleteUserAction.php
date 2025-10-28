<?php

namespace LiraUi\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use LiraUi\Auth\Contracts\DeletesUser;
use LiraUi\Auth\Events\UserDeletedEvent;
use LiraUi\Auth\Http\Requests\DeleteAccountRequest;

class DeleteUserAction implements DeletesUser
{
    /**
     * Delete the user's account.
     */
    public function delete(DeleteAccountRequest $request): void
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        Auth::logout();

        event(new UserDeletedEvent($user));

        $user->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
