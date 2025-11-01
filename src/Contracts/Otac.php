<?php

namespace LiraUi\Auth\Contracts;

interface Otac
{
    /**
     * Process the OTAC when verified.
     */
    public function process(): bool;
}
