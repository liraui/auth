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

        $validated = $request->validated();

        if ($validated['email'] !== $user->email) {
            $user->sendEmailVerificationNotification($validated['email']);
        }

        $user->fill([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
        ])->save();

        event(new ProfileUpdatedEvent($user));

        return $user;
    }
}
