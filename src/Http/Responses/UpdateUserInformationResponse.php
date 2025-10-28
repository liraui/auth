<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\UserInformationUpdated;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserInformationResponse implements UserInformationUpdated
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(FormRequest $request): Response
    {
        return $request->wantsJson()
                    ? response()->json(['success' => true, 'message' => 'Profile information updated successfully'])
                    : back()->with('status', 'profile-information-updated');
    }
}
