<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\PasskeyDeleted;
use LiraUi\Auth\Http\Requests\DeletePasskeyRequest;
use Symfony\Component\HttpFoundation\Response;

class DeletePasskeyResponse implements PasskeyDeleted
{
    /**
     * Create an HTTP response for when a passkey is deleted.
     */
    public function toResponse(DeletePasskeyRequest $request): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Passkey has been deleted.',

            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Passkey has been deleted.',
        ]);
    }
}
