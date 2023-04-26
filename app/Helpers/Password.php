<?php

namespace App\Helpers;

class Password
{

    /**
     * Genera un hash a partir de un password
     * @param string $password
     * @return string
     */
    public static function generateHashedPassword($password)
    {
        $pepperedPassword = $password . $_ENV['SECRET_PEPPER']; // Se concatena la pimienta al password
        return password_hash($pepperedPassword, PASSWORD_DEFAULT, ['cost' => 12]); // Se crea el hash utilizando la función password_hash, la salt se omite ya que a partir de php 7, esta se autogenera
    }

    /**
     * Verifica que el password coincida con el hash
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verifyPassword($password, $hash)
    {
        $pepperedPassword = $password . $_ENV['SECRET_PEPPER'];

        return password_verify($pepperedPassword, $hash);
    }

    public static function generateToken($length = 32)
    {
        return bin2hex(random_bytes($length));
    }
}