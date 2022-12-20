<?php

namespace Lab4;

use PHPUnit\Framework\TestCase;

class MathModuleTest extends TestCase
{
	public function testDcDex(): void
	{
		$a = 612;
		$b = 342;

		[$d, $x, $y] = MathModule::gcDex($a, $b);

		$this->assertSame($d, ($a * $x + $b * $y));
	}

	public function testInverseElement()
	{
		$a = 5;
		$n = 18;

		$invert = MathModule::inverseElement($a, $n);

		$this->assertSame(11, $invert);
	}

	public function testPhi()
	{
		$n = 18;

		$phi = MathModule::phi($n);

		$this->assertSame(6, $phi);
	}

	public function testInverseElementByPhi()
	{
		$a = 5;
		$n = 18;

		$invert = MathModule::inverseElementByPhi($a, $n);

		$this->assertSame(11, $invert);
	}
}
