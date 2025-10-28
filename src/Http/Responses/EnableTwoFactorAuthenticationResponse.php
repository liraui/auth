<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\TwoFactorAuthenticationEnabled;
use Symfony\Component\HttpFoundation\Response;

class EnableTwoFactorAuthenticationResponse implements TwoFactorAuthenticationEnabled
{
    /**
     * Create an HTTP response for when two-factor authentication is enabled.
     */
    public function toResponse(FormRequest $request, array $data): Response
    {
        return $request->wantsJson()
            ? response()->json([
                'success' => true,
                'data' => $data,
            ])
            : back()->with('flash', $data);
    }
}
