<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\InvalidateBrowserSessionRequest;

interface InvalidatesBrowserSession
{
    /**
     * Invalidate a specific browser session.
     */
    public function invalidate(InvalidateBrowserSessionRequest $request): void;
}
