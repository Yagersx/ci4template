<?php

class Password
{
    public static function generateSalt($bytes = 16)
    {
        return bin2hex(random_bytes($bytes));
    }
    public static function generatePassword($password)
    {
        $salt = self::generateSalt(); // Se genera una sal aleatoria
        return password_hash($password, PASSWORD_DEFAULT, ['salt' => $salt]); // Se crea el hash utilizando la función password_hash y la sal
    }
}