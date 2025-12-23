<?php

namespace LiraUi\Auth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \LiraUi\Auth\Otac\OtacStore store()
 * @method static \LiraUi\Auth\Otac\Otac identifier(string $identifier)
 * @method static array<string, mixed> send(\LiraUi\Auth\Contracts\Otac $otac, mixed $notifiable, int $length = 6, int $expireInMinutes = 10)
 * @method static \LiraUi\Auth\Otac\OtacVerificationResult verify(string $code)
 * @method static \LiraUi\Auth\Otac\OtacVerificationResult check(string $code)
 * @method static \LiraUi\Auth\Otac\OtacVerificationResult attempt(string $code)
 */
class Otac extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'liraui-auth-otac';
    }
}
