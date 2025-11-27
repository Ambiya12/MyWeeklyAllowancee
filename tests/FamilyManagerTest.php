<?php

namespace MyWeeklyAllowancee\tests;

use PHPUnit\Framework\TestCase;
use App\FamilyManager;
use RuntimeException;

class FamilyManagerTest extends TestCase
{
    private FamilyManager $manager;

    protected function setUp(): void
    {
        $this->manager = new FamilyManager();
    }

    // Antoine
    public function testAddTeenAndGetWallet(): void
    {
        $this->manager->addTeen('Anatole', 5.0);
        $wallet = $this->manager->getWallet('Anatole');
        $this->assertSame(0.0, $wallet->getBalance());
    }
    // Antoine
    public function testDepositAndSpend(): void
    {
        $this->manager->addTeen('Galyst', 10.0);
        $this->manager->depositToTeen('Galyst', 20.0);
        $this->assertSame(20.0, $this->manager->getWallet('Galyst')->getBalance());

        $this->manager->spendFromTeen('Galyst', 5.0);
        $this->assertSame(15.0, $this->manager->getWallet('Galyst')->getBalance());
    }
    // Galyst
    public function testWeeklyAllowance(): void
    {
        $this->manager->addTeen('Antoine', 7.0);

        $this->manager->processAllWeeklyAllowances();
        $this->assertSame(7.0, $this->manager->getWallet('Antoine')->getBalance());

        $this->manager->processAllWeeklyAllowances();
        $this->assertSame(14.0, $this->manager->getWallet('Antoine')->getBalance());
    }
    // Galyst
    public function testMultipleTeens(): void
    {
        $this->manager->addTeen('Anatoine', 2.0);
        $this->manager->addTeen('Anatole', 3.0);

        $this->manager->depositToTeen('Anatoine', 5.0);
        $this->manager->depositToTeen('Anatole', 10.0);
        $this->manager->processAllWeeklyAllowances();

        $this->assertSame(7.0, $this->manager->getWallet('Anatoine')->getBalance());
        $this->assertSame(13.0, $this->manager->getWallet('Anatole')->getBalance());
    }
    // Anatole
    public function testAddTeenTwiceThrows(): void
    {
        $this->expectException(RuntimeException::class);
        $this->manager->addTeen('Galyst', 1.0);
        $this->manager->addTeen('Galyst', 2.0);
    }

    // Anatole
    public function testUnknownTeenThrows(): void
    {
        $this->expectException(RuntimeException::class);
        $this->manager->getWallet('Pierre');
    }
}
