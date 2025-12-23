<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\EnableTwoFactorRequest;
use Symfony\Component\HttpFoundation\Response;

interface TwoFactorEnabled
{
    /**
     * Create an HTTP response for when two-factor authentication is enabled.
     *
     * @param  array<string, string>  $data
     */
    public function toResponse(EnableTwoFactorRequest $request, array $data): Response;
}
