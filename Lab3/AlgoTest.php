<?php

namespace Lab3;

use PHPUnit\Framework\TestCase;

class AlgoTest extends TestCase
{
	public function testDefault(): void
	{
		$text = 'Merry Christmas and Happy New Year!';
		$key = 'BestWish';

		$algo = new Algo($key);

		$encryptedText = $algo->encrypt($text);

		$decryptedText = $algo->decrypt($encryptedText);

		$this->assertSame($text, $decryptedText);
	}
}
