<?php

namespace App\Libraries;

class MyCustomRules
{
    /**
     * Validate a string with only letters, numbers, spaces, dots, commas, accents, dashes, and hashtags.
     * @param string $value
     * @return bool
     */
    public function alpha_numeric_accent($value): bool
    {
        return preg_match('/^[\w\s.,áéíóúÁÉÍÓÚñÑüÜ\#\'-]*$/', $value);
    }
}