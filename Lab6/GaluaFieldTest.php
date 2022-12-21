<?php

namespace Lab6;

use PHPUnit\Framework\TestCase;

class GaluaFieldTest extends TestCase
{
	public function testDefault(): void
	{
		$a = 0xD4;
		$b = 0xBF;

		$r1 = dechex(GaluaField::multiBy02($a));
		$r2 = dechex(GaluaField::multiBy03($b));

		$this->assertSame('b3', $r1);
		$this->assertSame('da', $r2);

		$this->assertSame($r1, GaluaField::multi($a, 0x02));
		$this->assertSame($r2, GaluaField::multi($b, 0x03));
	}
}
