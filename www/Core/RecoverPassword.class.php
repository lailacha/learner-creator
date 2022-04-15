<?php

namespace App\Core;

class RecoverPassword
{
    public static function sendMail()
    {
        $bytes = random_bytes(128);
        $token = substr(str_shuffle(bin2hex($bytes)), 0, 255);

    }
}