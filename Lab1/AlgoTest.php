<?php

namespace Lab1;

use PHPUnit\Framework\TestCase;

class AlgoTest extends TestCase
{
	public function testDefault(): void
	{
		$columnKey = 'crypto';
		$rowKey = 'tare';
		$text = 'firstcryptomessagetoyou';

		$algo = new Algo($columnKey, $rowKey);
		$encryptedText = $algo->encrypt($text);

		$decryptedText = $algo->decrypt($encryptedText);

		$this->assertSame($text, $decryptedText);
	}
}
