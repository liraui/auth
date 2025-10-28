<?php

namespace LiraUi\Auth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \LiraUi\Auth\Otp\OtpStore store()
 * @method static \LiraUi\Auth\Otp\Otp identifier(string $identifier)
 * @method static array send(\LiraUi\Auth\Contracts\Otp $otp, mixed $notifiable, ?int $length = null, ?int $expireInMinutes = null)
 * @method static \LiraUi\Auth\Otp\OtpVerificationResult verify(string $code)
 * @method static \LiraUi\Auth\Otp\OtpVerificationResult check(string $code)
 * @method static \LiraUi\Auth\Otp\OtpVerificationResult attempt(string $code)
 */
class Otp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'liraui-auth-otp';
    }
}
