<?php

namespace Lab5;

use Illuminate\Support\Str;
use LogicException;

class RabinMiller
{
	public static function isSimple(int $n, int $k): bool
	{
		if ($n < 2 || $n % 2 == 0) {
			return $n == 2;
		}

		$s = $n - 1;

		while ($s % 2 == 0) {
			$s >>= 1;
		}

		for ($i = 0; $i < $k; $i++) {
			$a = random_int(0, $n - 1) + 1;

			$temp = $s;
			$mod = 1;

			for ($j = 0; $j < $temp; $j++) {
				$mod = ($mod * $a) % $n;
			}

			while ($temp != $n - 1 &&
				$mod != 1 &&
				$mod != $n - 1) {
				$mod = $mod * $mod % $n;
				$temp *= 2;
			}

			if ($mod != $n - 1 && $temp % 2 == 0) {
				return false;
			}
		}

		return true;
	}
}
