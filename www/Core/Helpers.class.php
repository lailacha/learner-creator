<?php

namespace App\Core;

class Helpers
{

public static function createToken() : string{
    $bytes = random_bytes(128);
    return substr(str_shuffle(bin2hex($bytes)), 0, 255);
	}


    public static function slugify($text, string $divider = '-')
{
  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  $text = preg_replace('~[^-\w]+~', '', $text);

  $text = trim($text, $divider);

  $text = preg_replace('~-+~', $divider, $text);

  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

}