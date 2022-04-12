<?php

namespace App\Core;

class Helpers
{

public static function createToken(){
		return substr(md5(uniqid(true)), 0, 10); 
	}

}