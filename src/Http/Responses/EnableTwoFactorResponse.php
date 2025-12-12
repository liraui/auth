<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\TwoFactorEnabled;
use LiraUi\Auth\Http\Requests\EnableTwoFactorRequest;
use Symfony\Component\HttpFoundation\Response;

class EnableTwoFactorResponse implements TwoFactorEnabled
{
    /**
     * Create an HTTP response for when two-factor authentication is enabled.
     */
    public function toResponse(EnableTwoFactorRequest $request, array $data): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Two-factor authentication has been enabled.',
                ...$data,
            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Two-factor authentication has been enabled.',
            ...$data,
        ]);
    }
}
