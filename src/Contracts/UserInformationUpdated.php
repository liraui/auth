<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ResetPasswordRequest;
use Symfony\Component\HttpFoundation\Response;

interface UserInformationUpdated
{
    /**
     * Create an HTTP response for when user information is updated.
     */
    public function toResponse(ResetPasswordRequest $request): Response;
}
