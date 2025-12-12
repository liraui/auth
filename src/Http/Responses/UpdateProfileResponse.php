<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\ProfileUpdated;
use LiraUi\Auth\Http\Requests\UpdateProfileRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateProfileResponse implements ProfileUpdated
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(UpdateProfileRequest $request): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Profile information updated successfully',
            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Profile information updated successfully',
        ]);
    }
}
