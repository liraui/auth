<?php

namespace LiraUi\Auth\Otac;

use Illuminate\Support\Facades\Cache;
use LiraUi\Auth\Contracts\OtacStore as OtacStoreContract;

class OtacStore implements OtacStoreContract
{
    const STORE_KEY = 'liraui_auth_otac';

    protected string $identifier;

    public function identifier(string $identifier): static
    {
        if (empty($identifier)) {
            throw new \Exception('OTAC identifier is empty!');
        }

        $this->identifier = md5($identifier);

        return $this;
    }

    public function put(array $otac): void
    {
        Cache::put(
            $this->getCacheKey(),
            $otac,
            $otac['expires']
        );
    }

    public function retrieve(): ?array
    {
        return Cache::get($this->getCacheKey()) ?: null;
    }

    public function clear(): void
    {
        Cache::forget($this->getCacheKey());
    }

    protected function getCacheKey(): string
    {
        if (! isset($this->identifier)) {
            throw new \Exception('No OTAC identifier set!');
        }

        return static::STORE_KEY.'_'.$this->identifier;
    }
}
