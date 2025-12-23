<?php

namespace LiraUi\Auth\Actions;

use App\Models\User;
use LiraUi\Auth\Contracts\UpdatesProfile;
use LiraUi\Auth\Events\ProfileUpdatedEvent;
use LiraUi\Auth\Http\Requests\UpdateProfileRequest;

class UpdateProfileAction implements UpdatesProfile
{
    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request): User
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var string $email */
        $email = $request->input('email');

        if ($email !== $user->email) {
            $user->sendEmailVerificationNotification($email);
        }

        $user->fill([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
        ])->save();

        event(new ProfileUpdatedEvent($user));

        return $user;
    }
}
