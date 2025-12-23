<?php

namespace LiraUi\Auth\Otac;

use Carbon\Carbon;
use Illuminate\Support\Str;
use LiraUi\Auth\Contracts\Otac as OtacContract;
use LiraUi\Auth\Notifications\OtacNotification;

class Otac
{
    /**
     * Create a new OTAC instance.
     */
    public function __construct(
        protected OtacStore $store
    ) {
        //
    }

    /**
     * Get the OTAC store.
     */
    public function store(): OtacStore
    {
        return $this->store;
    }

    public function identifier(string $identifier): static
    {
        $this->store->identifier($identifier);

        return $this;
    }

    /**
     * Send the OTAC notification.
     *
     * @return array<string, mixed>
     */
    public function send(OtacContract $otac, mixed $notifiable, int $length = 6, int $expireInMinutes = 10): array
    {
        assert(is_object($notifiable) && method_exists($notifiable, 'notify'));

        $code = $this->generateCode($length);

        $expires = Carbon::now()->addMinutes($expireInMinutes)->addSeconds(59);

        $otacData = [
            'code' => $code,
            'expires' => $expires,
            'otac' => $otac,
            'otac_class' => serialize($otac),
        ];

        $this->store->put($otacData);

        $notifiable->notify(new OtacNotification([
            'code' => $code,
            'expires' => $expires->diffForHumans(),
        ]));

        return $otacData;
    }

    /**
     * Verify the OTAC code and process the associated action.
     */
    public function verify(string $code): OtacVerificationResult
    {
        $otac = $this->store->retrieve();

        if (! $otac) {
            return new OtacVerificationResult(false, null, 'No OTAC found for this identifier');
        }

        /** @var \Carbon\Carbon $expiresIn */
        $expiresIn = $otac['expires'];

        if (Carbon::now()->gt($expiresIn)) {
            return new OtacVerificationResult(false, null, 'OTAC has expired');
        }

        if ($otac['code'] !== $code) {
            return new OtacVerificationResult(false, null, 'Invalid OTAC code');
        }

        /** @var \LiraUi\Auth\Contracts\Otac $otacObject */
        $otacObject = $otac['otac'];

        $otacObject->process();

        $this->store->clear();

        return new OtacVerificationResult(true, $otacObject);
    }

    /**
     * Check the OTAC code without processing or clearing it.
     */
    public function check(string $code): OtacVerificationResult
    {
        $otac = $this->store->retrieve();

        if (! $otac) {
            return new OtacVerificationResult(false, null, 'No OTAC found for this identifier');
        }

        /** @var \Carbon\Carbon $expiresIn */
        $expiresIn = $otac['expires'];

        if (Carbon::now()->gt($expiresIn)) {
            return new OtacVerificationResult(false, null, 'OTAC has expired');
        }

        if ($otac['code'] !== $code) {
            return new OtacVerificationResult(false, null, 'Invalid OTAC code');
        }

        /** @var \LiraUi\Auth\Contracts\Otac $otacContract */
        $otacContract = $otac['otac'];

        return new OtacVerificationResult(true, $otacContract);
    }

    /**
     * Attempt to verify the OTAC code.
     */
    public function attempt(string $code): OtacVerificationResult
    {
        return $this->verify($code);
    }

    /**
     * Generate a random numeric code of the given length.
     */
    protected function generateCode(int $length): string
    {
        return Str::padLeft((string) random_int(0, pow(10, $length) - 1), $length, '0');
    }
}
