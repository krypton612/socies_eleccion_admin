<?php

// app/Services/CustomHashManager.php

namespace App\Services;

use Illuminate\Hashing\HashManager;
use Illuminate\Hashing\BcryptHasher;

class CustomHashManager extends HashManager
{
    /**
     * Create an instance of the Bcrypt hash Driver.
     *
     * @return \App\Services\CustomBcryptHasher
     */
    public function createBcryptDriver()
    {
        return new CustomBcryptHasher($this->config->get('hashing.bcrypt', []));
    }
}

class CustomBcryptHasher extends BcryptHasher
{
    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array  $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }

        // ✅ Convertir $2a$ (Python bcrypt) a $2y$ (PHP bcrypt)
        if (str_starts_with($hashedValue, '$2a$')) {
            $hashedValue = '$2y$' . substr($hashedValue, 4);
        }

        return password_verify($value, $hashedValue);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @param  array  $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        // Convertir $2a$ a $2y$ antes de verificar si necesita rehash
        if (str_starts_with($hashedValue, '$2a$')) {
            $hashedValue = '$2y$' . substr($hashedValue, 4);
        }

        return password_needs_rehash($hashedValue, PASSWORD_BCRYPT, [
            'cost' => $this->cost($options),
        ]);
    }
}