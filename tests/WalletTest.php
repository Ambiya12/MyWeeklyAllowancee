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
}