<?php

namespace Lab1;

use Illuminate\Support\Str;
use LogicException;

class Algo
{
	private readonly int $maxLength;

	private readonly array $dechiperColumnKey;

	private readonly array $dechiperRowKey;

	public function __construct(
		private readonly string $columnKey,
		private readonly string $rowKey
	) {
		$this->maxLength = Str::length($this->columnKey) * Str::length($this->rowKey);

		$dechiperColumnKey = array_flip(mb_str_split($this->columnKey));
		$dechiperRowKey = array_flip(mb_str_split($this->rowKey));
		ksort($dechiperColumnKey);
		ksort($dechiperRowKey);
		$this->dechiperColumnKey = array_values($dechiperColumnKey);
		$this->dechiperRowKey = array_values($dechiperRowKey);
	}

	public function encrypt(string $value): string
	{
		if (Str::length($value) > $this->maxLength) {
			throw new LogicException('Input text cannot be longer then keys');
		}

		$matrix = $this->createMatrix($value);

		$sortedByRow = array_map(fn ($item) => implode('', collect($item)->sortKeys()->toArray()), $matrix);

		ksort($sortedByRow);

		return implode('', $sortedByRow);
	}

	public function decrypt(string $value): string
	{
		if (Str::length($value) > $this->maxLength) {
			throw new LogicException('Input text cannot be longer then keys');
		}

		$matrix = $this->createMatrix($value, true);

		$sortedByRow = array_map(fn ($item) => implode('', collect($item)->sortKeys()->toArray()), $matrix);

		ksort($sortedByRow);

		return implode('', $sortedByRow);
	}

	private function createMatrix(string $value, bool $decrypt = false): array
	{
		$width = Str::length($this->columnKey);
		$height = Str::length($this->rowKey);
		$columnKeyArray = $decrypt ? $this->dechiperColumnKey : mb_str_split($this->columnKey);
		$rowKeyArray = $decrypt ? $this->dechiperRowKey : mb_str_split($this->rowKey);

		$matrix = [];
		$valueArray = mb_str_split($value);

		for ($i = 0; $i < $height; $i++) {
			$sliced = array_slice($valueArray, $i * $width, $width);

			//Fill empty keys
			if (count($sliced) < count($columnKeyArray)) {
				$diffKeys = count($columnKeyArray) - count($sliced);

				while ($diffKeys > 0) {
					$sliced[] = '_';
					$diffKeys--;
				}
			}
			$matrix[$rowKeyArray[$i]] = array_combine($columnKeyArray, $sliced);
		}

		return $matrix;
	}
}
