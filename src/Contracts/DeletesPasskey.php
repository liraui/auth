<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\DeletePasskeyRequest;

interface DeletesPasskey
{
    /**
     * Delete the user's passkey.
     */
    public function delete(DeletePasskeyRequest $request): void;
}
