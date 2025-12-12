<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\BrowserSessionInvalidated;
use LiraUi\Auth\Http\Requests\InvalidateBrowserSessionRequest;
use Symfony\Component\HttpFoundation\Response;

class InvalidateBrowserSessionResponse implements BrowserSessionInvalidated
{
    /**
     * Create an HTTP response for when a browser session is invalidated.
     */
    public function toResponse(InvalidateBrowserSessionRequest $request): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Session has been invalidated.',
            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Session has been invalidated.',
        ]);
    }
}
