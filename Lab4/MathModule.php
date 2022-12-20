<?php

namespace Lab4;

use Illuminate\Support\Str;
use LogicException;

class MathModule
{
	public static function gcDex(int $a, int $b): array
	{
		if ($a === 0) {
			return [$b, 0, 1];
		}

		$a0 = $a;
		$a1 = $b;
		$x0 = 1;
		$x1 = 0;
		$y0 = 0;
		$y1 = 1;

		while ($a1 != 0) {
			$q = intdiv($a0, $a1);

			[$a0, $a1] = [$a1, $a0 - $q * $a1];
			[$x0, $x1] = [$x1, $x0 - $q * $x1];
			[$y0, $y1] = [$y1, $y0 - $q * $y1];
		}

		return [$a0, $x0, $y0];
	}

	public static function inverseElement(int $a, int $n): int
	{
		[, $x,] = self::gcDex($a, $n);

		return ($x % $n + $n) % $n;
	}

	public static function phi(int $n): int
	{
		$result = 1;

		for ($i = 2; $i < $n; $i++) {
			[$d,,] = self::gcDex($i, $n);

			if ($d === 1) {
				$result++;
			}
		}

		return $result;
	}

	public static function inverseElementByPhi(int $a, int $n): int
	{
		return self::isMain($n) ? self::powByModule($a, $n - 2, $n) : self::powByModule($a, self::phi($n) - 1, $n);
	}

	private static function isMain(int $n): bool
	{
		for ($i = 2; $i < $n; $i++) {
			if ($n % $i == 0) {
				return false;
			}
		}

		return true;
	}

	private static function powByModule(int $x, int $y, int $n): int
	{
		if ($y == 0) {
			return 1;
		}

		$p = self::powByModule($x, intdiv($y, 2), $n) % $n;
		$p = $p * $p % $n;

		return $y % 2 == 0 ? $p : $x * $p % $n;
	}
}
