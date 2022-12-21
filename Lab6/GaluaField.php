<?php

namespace Lab6;

use Illuminate\Support\Str;
use LogicException;

class GaluaField
{
	public const POLY = 0x11B;

	public static function multiBy02(int $b): int
	{
		$b7 = $b >> 7;

		return ($b << 1) ^ ($b7 * self::POLY);
	}

	public static function multiBy03(int $b): int
	{
		return self::multiBy02($b) ^ $b ^ 0;
	}

	public static function multi(int $b0, int $b1): string
	{
		$result = 0;

		for ($i = 0; $i < 8; $i++) {
			$result <<= 1;

			if (($result & 0x100) != 0) {
				$result ^= self::POLY;
			}

			if (($b0 & 0x80) != 0) {
				$result ^= $b1;
			}

			$b0 <<= 1;
		}

		return dechex($result);
	}
}
