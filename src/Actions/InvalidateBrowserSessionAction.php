<?php

namespace LiraUi\Auth\Actions;

use Illuminate\Support\Facades\DB;
use LiraUi\Auth\Contracts\InvalidatesBrowserSession;
use LiraUi\Auth\Http\Requests\InvalidateBrowserSessionRequest;

class InvalidateBrowserSessionAction implements InvalidatesBrowserSession
{
    /**
     * Invalidate a specific browser session.
     */
    public function invalidate(InvalidateBrowserSessionRequest $request, string $sessionId): void
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        DB::table('sessions')->where('user_id', $user->id)->where('id', $sessionId)->delete();
    }
}
