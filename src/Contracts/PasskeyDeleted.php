<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\DeletePasskeyRequest;
use Symfony\Component\HttpFoundation\Response;

interface PasskeyDeleted
{
    /**
     * Create an HTTP response for when a passkey is deleted.
     */
    public function toResponse(DeletePasskeyRequest $request): Response;
}
