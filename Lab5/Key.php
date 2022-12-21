<?php

namespace Lab5;

use Illuminate\Support\Str;
use LogicException;

class Key
{
	public function __construct(
		public readonly int $E,
		public readonly int $N,
		public readonly int|null $D = null,
	) {
	}

	public function isPublic(): bool
	{
		return $this->D === null;
	}

	public function isPrivate(): bool
	{
		return $this->D !== null;
	}
}
