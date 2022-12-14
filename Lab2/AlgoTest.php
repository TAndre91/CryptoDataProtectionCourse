<?php

namespace Lab2;

use PHPUnit\Framework\TestCase;

class AlgoTest extends TestCase
{
	public function testDefault(): void
	{
		$text = 'заміна';

		$algo = new Algo('абвгдеєжзиійклмнопрстуфхцчшьюя', '6');
		$encryptedText = $algo->encrypt($text);

		$decryptedText = $algo->decrypt($encryptedText);

		$this->assertSame($text, $decryptedText);
	}
}
