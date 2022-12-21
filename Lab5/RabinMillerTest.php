<?php

namespace Lab5;

use PHPUnit\Framework\TestCase;

class RabinMillerTest extends TestCase
{
	public function testIsSimple(): void
	{
		$n = 17;
		$k = 10;

		$result = RabinMiller::isSimple($n, $k);

		$this->assertTrue($result);
		$this->assertFalse(RabinMiller::isSimple(18, $k));
	}
}
