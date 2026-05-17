<?php

namespace LiraUi\Auth\Actions;

use Laravel\Passkeys\Events\PasskeyDeleted;
use Laravel\Passkeys\Passkey;
use LiraUi\Auth\Contracts\DeletesPasskey;
use LiraUi\Auth\Http\Requests\DeletePasskeyRequest;

class DeletePasskeyAction implements DeletesPasskey
{
    /**
     * Delete the user's passkey.
     */
    public function delete(DeletePasskeyRequest $request): void
    {
        /** @var Passkey $passkey */
        $passkey = $request->route('passkey');

        $passkey->delete();

        PasskeyDeleted::dispatch($request->user(), $passkey);
    }
}
