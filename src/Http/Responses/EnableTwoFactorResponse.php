<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\TwoFactorEnabled;
use Symfony\Component\HttpFoundation\Response;

class EnableTwoFactorResponse implements TwoFactorEnabled
{
    /**
     * Create an HTTP response for when two-factor authentication is enabled.
     */
    public function toResponse(FormRequest $request, array $data): Response
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
