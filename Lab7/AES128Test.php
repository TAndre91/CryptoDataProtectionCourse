<?php

namespace Lab7;

use PHPUnit\Framework\TestCase;

class AES128Test extends TestCase
{
	public function testDefault(): void
	{
		$key1 = [];
		$randomBytes = mb_str_split(bin2hex(random_bytes(16)), 2);
		array_map(function ($item) use (&$key1) {
			$key1[] = hexdec($item);
		}, $randomBytes);

		$text = 'Hello from world';
		$textToHex = [];

		array_map(function ($item) use (&$textToHex) {
			$textToHex[] = hexdec($item);
		}, mb_str_split(bin2hex($text), 2));

		$text2 = $key1;

		// MixColumn and InverseMixColumn check
		AES128::MixColumn($text2);
		$this->assertNotSame($key1, $text2);
		AES128::InverseMixColumn($text2);
		$this->assertSame($key1, $text2);

		// ShiftRows and InverseShiftRows check
		AES128::ShiftRows($text2);
		$this->assertNotSame($key1, $text2);
		AES128::InverseShiftRows($text2);
		$this->assertSame($key1, $text2);

		$aes = new AES128();
		$aes->setKey($key1);
		$encrypted = $aes->encrypt($textToHex);
		$decrypted = $aes->decrypt($encrypted);

		$decryptedText = $this->arrayToText($decrypted);

		$this->assertSame($text, $decryptedText);
	}

	private function arrayToText(array $arr): string
	{
		$result = '';
		array_map(function ($item) use (&$result) {
			$result .= dechex($item);
		}, $arr);

		return hex2bin($result);
	}
}
