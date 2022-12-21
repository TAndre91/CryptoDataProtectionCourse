<?php

namespace Lab5;

use Lab4\MathModule;
use LogicException;

class KeyPairGenerator
{
	public readonly Key $publicKey;

	public readonly Key $privateKey;

	public function __construct(int $n, int $d, int $e)
	{
		$this->publicKey = new Key($e, $n);
		$this->privateKey = new Key($e, $n, $d);
	}

	public static function generate(int $bitLength): self
	{
		[$p, $q] = self::findPrimeNumbers($bitLength);

		$n = $p * $q;
		$phi = ($p - 1) * ($q - 1);
		$e = 3;

		while ($e < $phi) {
			[$d,,] = MathModule::gcDex($e, $phi);

			if ($d == 1) {
				break;
			}
			$e++;
		}

		$d = MathModule::inverseElementByPhi($e, $phi);

		return new self($n, $d, $e);
	}

	public static function findPrimeNumbers(int $bitLength): array
	{
		$first = -1;

		if ($bitLength <= 0 || $bitLength > 32) {
			throw new LogicException();
		}
		$randomBytes = self::binRandom(intdiv(($bitLength + 8 - 1), 8));

		if (mb_strlen($randomBytes) != 4) {
			$randomBytes .= self::binRandom(4 - mb_strlen($randomBytes));
		}

		$randomNum = self::intval_32bits($randomBytes);

		while (true) {
			if (RabinMiller::isSimple($randomNum, 40)) {
				if ($first == -1) {
					$first = $randomNum;
					$randomNum++;

					continue;
				}

				$second = $randomNum;

				return [$first, $second];
			}

			$randomNum++;
		}
	}

	private static function intval_32bits(int $value): int
	{
		$value = ($value & 0xFFFFFFFF);

		if ($value & 0x80000000) {
			$value = -((~$value & 0xFFFFFFFF) + 1);
		}

		return $value;
	}

	private static function binRandom($length): string
	{
		$bin = '';

		while ($length--) {
			$bin .= mt_rand(0, 1);
		}

		return $bin;
	}
}
