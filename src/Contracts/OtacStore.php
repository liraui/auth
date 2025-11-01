<?php

namespace LiraUi\Auth\Contracts;

interface OtacStore
{
    /**
     * Set identifier for the OTAC.
     */
    public function identifier(string $identifier): static;

    /**
     * Store OTAC in cache.
     */
    public function put(array $otac): void;

    /**
     * Get OTAC from cache.
     */
    public function retrieve(): ?array;

    /**
     * Remove OTAC from cache.
     */
    public function clear(): void;
}
