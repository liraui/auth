<?php

namespace LiraUi\Auth\Otp;

use Carbon\Carbon;
use Illuminate\Support\Str;
use LiraUi\Auth\Contracts\Otp as OtpContract;
use LiraUi\Auth\Notifications\OtpNotification;

class Otp
{
    /**
     * OTP store instance
     *
     * @var OtpStore
     */
    protected $store;

    /**
     * Create a new OTP instance.
     */
    public function __construct(OtpStore $store)
    {
        $this->store = $store;
    }

    /**
     * Get OTP store instance
     */
    public function store(): OtpStore
    {
        return $this->store;
    }

    /**
     * Set identifier
     */
    public function identifier(string $identifier): static
    {
        $this->store->identifier($identifier);

        return $this;
    }

    /**
     * Send OTP
     */
    public function send(OtpContract $otp, $notifiable, ?int $length = 6, ?int $expireInMinutes = 10): array
    {
        $code = $this->generateCode($length);

        $expires = Carbon::now()->addMinutes($expireInMinutes)->addSeconds(59);

        $otp_data = [
            'code' => $code,
            'expires' => $expires,
            'otp' => $otp,
            'otp_class' => serialize($otp),
        ];

        $this->store->put($otp_data);

        $notifiable->notify(new OtpNotification([
            'code' => $code,
            'expires' => $expires->diffForHumans(),
        ]));

        return $otp_data;
    }

    /**
     * Verify OTP
     */
    public function verify(string $code): OtpVerificationResult
    {
        $otp = $this->store->retrieve();

        if (! $otp) {
            return new OtpVerificationResult(false, null, 'No OTP found for this identifier');
        }

        if (Carbon::now()->gt($otp['expires'])) {
            return new OtpVerificationResult(false, null, 'OTP has expired');
        }

        if ($otp['code'] !== $code) {
            return new OtpVerificationResult(false, null, 'Invalid OTP code');
        }

        $otp_object = $otp['otp'];

        $processed = $otp_object->process();

        $this->store->clear();

        return new OtpVerificationResult(true, $otp_object);
    }

    /**
     * Check OTP without clearing it from cache
     */
    public function check(string $code): OtpVerificationResult
    {
        $otp = $this->store->retrieve();

        if (! $otp) {
            return new OtpVerificationResult(false, null, 'No OTP found for this identifier');
        }

        if (Carbon::now()->gt($otp['expires'])) {
            return new OtpVerificationResult(false, null, 'OTP has expired');
        }

        if ($otp['code'] !== $code) {
            return new OtpVerificationResult(false, null, 'Invalid OTP code');
        }

        return new OtpVerificationResult(true, $otp['otp']);
    }

    /**
     * Attempt to verify OTP
     */
    public function attempt(string $code): OtpVerificationResult
    {
        return $this->verify($code);
    }

    /**
     * Generate OTP code
     */
    protected function generateCode(int $length): string
    {
        return Str::padLeft(random_int(0, pow(10, $length) - 1), $length, '0');
    }
}
