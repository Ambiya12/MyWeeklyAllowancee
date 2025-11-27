<?php

namespace MyWeeklyAllowance;

use PHPUnit\Framework\TestCase;
use App\Wallet;

class WalletTest extends TestCase {

    // Antoine
    public function testNewWalletHasZeroBalance(): void
    {
        $wallet = new Wallet();
        $this->assertSame(0.0, $wallet->getBalance());
    }
    // Antoine
    public function testDepositIncreasesBalance(): void
    {
        $wallet = new Wallet();
        $wallet->deposit(50.0);

        $this->assertSame(50.0, $wallet->getBalance());
    }
    // Galyst
    public function testCannotDepositNegativeAmount(): void
    {
        $wallet = new Wallet();
        $this->expectException(\InvalidArgumentException::class);
        $wallet->deposit(-10);
    }
    // Galyst
    public function testSpendDecreasesBalance(): void
    {
        $wallet = new Wallet();
        $wallet->deposit(100.0);

        $wallet->spend(20.0, 'Test');

        $this->assertSame(80.0, $wallet->getBalance());
    }
    // Galyst
    public function testCannotSpendMoreThanBalance(): void
    {
        $wallet = new Wallet();
        $wallet->deposit(10.0);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Fonds insuffisants");

        $wallet->spend(50.0);
    }
}