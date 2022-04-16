<?php

namespace App\Core;

class Helpers
{

public static function createToken() : string{
    $bytes = random_bytes(128);
    return substr(str_shuffle(bin2hex($bytes)), 0, 255);
	}

}