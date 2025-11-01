<?php

namespace LiraUi\Auth\Otac;

use Carbon\Carbon;
use Illuminate\Support\Str;
use LiraUi\Auth\Contracts\Otac as OtacContract;
use LiraUi\Auth\Notifications\OtacNotification;

class Otac
{
    public function __construct(
        protected OtacStore $store
    ) {
    }

    public function store(): OtacStore
    {
        return $this->store;
    }

    public function identifier(string $identifier): static
    {
        $this->store->identifier($identifier);

        return $this;
    }

    public function send(OtacContract $otac, mixed $notifiable, ?int $length = 6, ?int $expireInMinutes = 10): array
    {
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

    public function verify(string $code): OtacVerificationResult
    {
        $otac = $this->store->retrieve();

        if (! $otac) {
            return new OtacVerificationResult(false, null, 'No OTAC found for this identifier');
        }

        if (Carbon::now()->gt($otac['expires'])) {
            return new OtacVerificationResult(false, null, 'OTAC has expired');
        }

        if ($otac['code'] !== $code) {
            return new OtacVerificationResult(false, null, 'Invalid OTAC code');
        }

        $otacObject = $otac['otac'];

        $processed = $otacObject->process();

        $this->store->clear();

        return new OtacVerificationResult(true, $otacObject);
    }

    public function check(string $code): OtacVerificationResult
    {
        $otac = $this->store->retrieve();

        if (! $otac) {
            return new OtacVerificationResult(false, null, 'No OTAC found for this identifier');
        }

        if (Carbon::now()->gt($otac['expires'])) {
            return new OtacVerificationResult(false, null, 'OTAC has expired');
        }

        if ($otac['code'] !== $code) {
            return new OtacVerificationResult(false, null, 'Invalid OTAC code');
        }

        return new OtacVerificationResult(true, $otac['otac']);
    }

    public function attempt(string $code): OtacVerificationResult
    {
        return $this->verify($code);
    }

    protected function generateCode(int $length): string
    {
        return Str::padLeft(random_int(0, pow(10, $length) - 1), $length, '0');
    }
}
