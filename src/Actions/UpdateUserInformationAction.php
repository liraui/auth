<?php

namespace LiraUi\Auth\Actions;

use App\Models\User;
use LiraUi\Auth\Contracts\UpdatesUserInformation;
use LiraUi\Auth\Events\PersonalInformationUpdatedEvent;
use LiraUi\Auth\Http\Requests\UpdateProfileRequest;

class UpdateUserInformationAction implements UpdatesUserInformation
{
    /**
     * Update the user's personal information.
     *
     * @return User The updated user
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

        event(new PersonalInformationUpdatedEvent($user));

        return $user;
    }
}
