<?php

namespace App\Helpers;

class StringHelper {

    public function toUpperCase(string $value)
    {
        return strtoupper($value);
    }

    public function toLowerCase(string $value)
    {
        return strtolower($value);
    }
}
