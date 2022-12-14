<?php

namespace Lab2;

use Illuminate\Support\Str;
use LogicException;

class Algo
{
	private readonly int $matrixHeight;

	private readonly array $matrix;

	private readonly array $reverseMatrix;

	public function __construct(
		private readonly string $matrixChars,
		private readonly int $matrixWidth
	) {
		$this->matrixHeight = Str::length($this->matrixChars) / $this->matrixWidth;

		$matrix = [];
		$key = 0;

		for ($i = 1; $i <= $this->matrixHeight; $i++) {
			for ($j = 1; $j <= $this->matrixWidth; $j++) {
				$matrix[$i . $j] = Str::substr($this->matrixChars, $key, 1);
				$key++;
			}
		}

		$this->matrix = $matrix;
		$this->reverseMatrix = array_flip($matrix);
	}

	public function encrypt(string $value): string
	{
		$charsRowCodes = [];
		$charsColumnCodes = [];

		for ($i = 0; $i < Str::length($value); $i++) {
			$charsRowCodes[] = Str::substr($this->reverseMatrix[Str::substr($value, $i, 1)], 0, 1);
			$charsColumnCodes[] = Str::substr($this->reverseMatrix[Str::substr($value, $i, 1)], 1, 1);
		}

		$charsCode = implode('', array_merge($charsRowCodes, $charsColumnCodes));

		$result = '';

		for ($i = 0; $i < Str::length($charsCode); $i = $i + 2) {
			$result .= $this->matrix[Str::substr($charsCode, $i, 2)];
		}

		return $result;
	}

	public function decrypt(string $value): string
	{
		$charsCode = '';

		for ($i = 0; $i < Str::length($value); $i++) {
			$charsCode .= $this->reverseMatrix[Str::substr($value, $i, 1)];
		}

		$result = '';

		for ($i = 0; $i < Str::length($charsCode) / 2; $i++) {
			$j = Str::length($charsCode) / 2 + $i;
			$result .= $this->matrix[Str::substr($charsCode, $i, 1) . Str::substr($charsCode, $j, 1)];
		}

		return $result;
	}
}
