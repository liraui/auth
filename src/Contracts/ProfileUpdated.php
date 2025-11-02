<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\UpdateProfileRequest;
use Symfony\Component\HttpFoundation\Response;

interface ProfileUpdated
{
    /**
     * Create an HTTP response for when user profile is updated.
     */
    public function toResponse(UpdateProfileRequest $request): Response;
}
