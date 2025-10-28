<?php

namespace LiraUi\Auth\Otp;

use Illuminate\Support\Facades\Cache;
use LiraUi\Auth\Contracts\OtpStore as OtpStoreContract;

class OtpStore implements OtpStoreContract
{
    /**
     * Store key
     *
     * @var string
     */
    const STORE_KEY = 'liraui_auth_otp';

    /**
     * Store identifier
     *
     * @var string
     */
    protected $identifier;

    /**
     * Set identifier
     *
     * @throws \Exception
     */
    public function identifier(string $identifier): static
    {
        if (empty($identifier)) {
            throw new \Exception('OTP identifier is empty!');
        }
        $this->identifier = md5($identifier);

        return $this;
    }

    /**
     * Put Otp in cache
     */
    public function put(array $otp): void
    {
        Cache::put(
            $this->getCacheKey(),
            $otp,
            $otp['expires']
        );
    }

    /**
     * Get Otp in cache
     */
    public function retrieve(): ?array
    {
        return Cache::get($this->getCacheKey()) ?: null;
    }

    /**
     * Remove Otp from cache
     */
    public function clear(): void
    {
        Cache::forget($this->getCacheKey());
    }

    /**
     * Return the cache key
     *
     * @throws \Exception
     */
    protected function getCacheKey(): string
    {
        if (! isset($this->identifier)) {
            throw new \Exception('No OTP identifier set!');
        }

        return static::STORE_KEY.'_'.$this->identifier;
    }
}
