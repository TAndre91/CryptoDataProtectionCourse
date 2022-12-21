<?php

namespace Lab5;

use PHPUnit\Framework\TestCase;

class RSATest extends TestCase
{
	public function testDefault(): void
	{
		$keyPair = KeyPairGenerator::generate(4);

		$src = 18;

		$publicKeyE = $keyPair->publicKey->E;
		$publicKeyN = $keyPair->publicKey->N;
		$privateKeyD = $keyPair->privateKey->D;
		$privateKeyN = $keyPair->privateKey->N;

		$encrypted = RSA::encrypt($src, $keyPair->publicKey);

		$decrypted = RSA::decrypt($encrypted, $keyPair->privateKey);
		$this->assertSame($src, $decrypted);
	}
}
