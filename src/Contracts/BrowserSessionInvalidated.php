<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\InvalidateBrowserSessionRequest;
use Symfony\Component\HttpFoundation\Response;

interface BrowserSessionInvalidated
{
    /**
     * Create an HTTP response for when a browser session is invalidated.
     */
    public function toResponse(InvalidateBrowserSessionRequest $request): Response;
}
