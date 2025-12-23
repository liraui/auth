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
     *
     * @param  array<string, mixed>  $otac
     */
    public function put(array $otac): void;

    /**
     * Get OTAC from cache.
     *
     * @return ?array<string, mixed>
     */
    public function retrieve(): ?array;

    /**
     * Remove OTAC from cache.
     */
    public function clear(): void;
}
