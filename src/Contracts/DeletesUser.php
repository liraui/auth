<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\DeleteAccountRequest;

interface DeletesUser
{
    /**
     * Delete the user account.
     */
    public function delete(DeleteAccountRequest $request): void;
}
