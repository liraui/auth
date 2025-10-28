<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\BrowserSessionInvalidated;
use Symfony\Component\HttpFoundation\Response;

class InvalidateBrowserSessionResponse implements BrowserSessionInvalidated
{
    /**
     * Create an HTTP response for when a browser session is invalidated.
     */
    public function toResponse(FormRequest $request): Response
    {
        return $request->wantsJson()
            ? response()->json([
                'success' => true,
                'message' => 'Session has been invalidated.',
            ])
            : back()->with('status', 'Session has been invalidated.');
    }
}
