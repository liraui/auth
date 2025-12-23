<?php

namespace LiraUi\Auth\Otac;

use Illuminate\Support\Facades\Cache;
use LiraUi\Auth\Contracts\OtacStore as OtacStoreContract;

class OtacStore implements OtacStoreContract
{
    /**
     * Cache key prefix for storing OTAC data.
     *
     * @var string
     */
    const STORE_KEY = 'liraui_auth_otac';

    /**
     * Identifier key used to save and retrieve data.
     *
     * @var string|null
     */
    protected $identifier = null;

    /**
     * Set the identifier for the OTAC store.
     */
    public function identifier(string $identifier): static
    {
        if (empty($identifier)) {
            throw new \Exception('OTAC identifier is empty!');
        }

        $this->identifier = hash('sha256', $identifier);

        return $this;
    }

    /**
     * Store OTAC data in cache.
     *
     * @param  array<string, mixed>  $otac
     */
    public function put(array $otac): void
    {
        /** @var \Carbon\Carbon $expiresIn */
        $expiresIn = $otac['expires'];

        Cache::put(
            $this->getCacheKey(),
            $otac,
            $expiresIn
        );
    }

    /**
     * Retrieve OTAC data from cache.
     *
     * @return ?array<string, mixed>
     */
    public function retrieve(): ?array
    {
        $data = Cache::get($this->getCacheKey());

        if (! is_array($data)) {
            return null;
        }

        $result = [];

        foreach ($data as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            } else {
                return null;
            }
        }

        return $result;
    }

    /**
     * Clear OTAC data from cache.
     */
    public function clear(): void
    {
        Cache::forget($this->getCacheKey());
    }

    /**
     * Get the cache key for the current identifier.
     */
    protected function getCacheKey(): string
    {
        if (! isset($this->identifier)) {
            throw new \Exception('No OTAC identifier set!');
        }

        return sprintf('%s_%s', static::STORE_KEY, $this->identifier);
    }
}
