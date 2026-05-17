<?php

namespace LiraUi\Auth\Http\Responses;

use App\Models\User;
use Laravel\Passkeys\Contracts\PasskeyLoginResponse as VerifiedPasskey;
use Symfony\Component\HttpFoundation\Response;

class PasskeyVerifiedResponse implements VerifiedPasskey
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request): Response
    {
        $toRoute = config('passkeys.redirect', '/');

        if ($request->wantsJson()) {
            if ($request->session()->has('auth.two_factor.pending_id')) {
                return response()->json([
                    'type' => 'warning',
                    'message' => 'Please complete the two-factor authentication to proceed.',
                    'redirect' => route('two-factor.verify'),
                ]);
            }

            /** @var User $user */
            $user = $request->user();

            $name = $user->name;

            return response()->json([
                'type' => 'success',
                'message' => 'Welcome back, '.$name.'!',
                'redirect' => redirect()->intended($toRoute)->getTargetUrl(),
            ]);
        }

        if ($request->session()->has('auth.two_factor.pending_id')) {
            return redirect()->route('two-factor.verify')->with('flash', [
                'type' => 'warning',
                'message' => 'Please complete the two-factor authentication to proceed.',
            ]);
        }

        /** @var User $user */
        $user = $request->user();

        $name = $user->name;

        return redirect()->intended($toRoute)->with('flash', [
            'type' => 'success',
            'message' => 'Welcome back, '.$name.'!',
        ]);
    }
}
