<?php

namespace MyWeeklyAllowancee\tests;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Wallet;
use InvalidArgumentException;
use RuntimeException;

class WalletTest extends TestCase
{
    private Wallet $wallet;
    protected function setUp(): void
    {
        $this->wallet = new Wallet();
    }
    // Antoine
    public function testNewWalletHasZeroBalance(): void
    {
        $this->assertSame(0.0, $this->wallet->getBalance());
    }

    // Antoine
    public function testDepositIncreasesBalance(): void
    {
        $this->wallet->deposit(50.0);
        $this->assertSame(50.0, $this->wallet->getBalance());
    }
    // Galyst
    public function testCannotDepositNegativeAmount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->wallet->deposit(-10);
    }
    // Galyst
    public function testSpendDecreasesBalance(): void
    {
        $this->wallet->deposit(100.0);
        $this->wallet->spend(20.0, 'Test');
        $this->assertSame(80.0, $this->wallet->getBalance());
    }
    // Galyst
    public function testCannotSpendMoreThanBalance(): void
    {
        $this->wallet->deposit(10.0);
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Fonds insuffisants");
        $this->wallet->spend(50.0);
    }
    // Anatole
    public function testProcessWeeklyAllowanceAddsMoney(): void
    {
        $wallet = new Wallet(10.0);

        $wallet->processWeeklyAllowance();
        $this->assertSame(10.0, $wallet->getBalance());

        $wallet->processWeeklyAllowance();
        $this->assertSame(20.0, $wallet->getBalance());
    }
    // Anatole
    public function testSpendingIsRecordedInHistory(): void
    {
        $this->wallet->deposit(50.0);
        $this->wallet->spend(15.0, "Cinéma avec potes");
        $this->wallet->spend(5.0, "McDo");

        $history = $this->wallet->getHistory();

        $this->assertCount(2, $history);
        $this->assertSame(15.0, $history[0]['amount']);
        $this->assertSame("Cinéma avec potes", $history[0]['description']);
    }
    // Anatole
    public function testSetAllowance(): void
    {
        $this->wallet->setAllowance(25.0);
        $this->assertSame(25.0, $this->wallet->getAllowance());
    }
}