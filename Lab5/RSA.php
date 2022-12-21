<?php

namespace Lab5;

use Illuminate\Support\Str;
use LogicException;

class RSA
{
	public static function encrypt(int $src, Key $publicKey): int
	{
		return bcpowmod($src, $publicKey->E, $publicKey->N);
	}

	public static function decrypt(int $src, Key $privateKey): int
	{
		return bcpowmod($src, $privateKey->D, $privateKey->N);
	}
}
