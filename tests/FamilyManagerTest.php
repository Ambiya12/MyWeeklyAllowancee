<?php

namespace MyWeeklyAllowancee\tests;

use PHPUnit\Framework\TestCase;
use App\FamilyManager;

class FamilyManagerTest extends TestCase {
    // Antoine
    public function testAddTeenAndGetWallet()
    {
        $fm = new FamilyManager();
        $fm->addTeen('Anatole', 5.0);
        $wallet = $fm->getWallet('Anatole');
        $this->assertEquals(0.0, $wallet->getBalance());
    }

    // Antoine
    public function testDepositAndSpend()
    {
        $fm = new FamilyManager();
        $fm->addTeen('Galyst', 10.0);
        $fm->depositToTeen('Galyst', 20.0);
        $this->assertEquals(20.0, $fm->getWallet('Galyst')->getBalance());
        $fm->spendFromTeen('Galyst', 5.0);
        $this->assertEquals(15.0, $fm->getWallet('Galyst')->getBalance());
    }

    // Galyst
    public function testWeeklyAllowance()
    {
        $fm = new FamilyManager();
        $fm->addTeen('Antoine', 7.0);
        $fm->processAllWeeklyAllowances();
        $this->assertEquals(7.0, $fm->getWallet('Antoine')->getBalance());
        $fm->processAllWeeklyAllowances();
        $this->assertEquals(14.0, $fm->getWallet('Antoine')->getBalance());
    }

    // Galyst
    public function testMultipleTeens()
    {
        $fm = new FamilyManager();
        $fm->addTeen('Anatoine', 2.0);
        $fm->addTeen('Anatole', 3.0);
        $fm->depositToTeen('Anatoine', 5.0);
        $fm->depositToTeen('Anatole', 10.0);
        $fm->processAllWeeklyAllowances();
        $this->assertEquals(7.0, $fm->getWallet('Anatoine')->getBalance());
        $this->assertEquals(13.0, $fm->getWallet('Anatole')->getBalance());
    }

    // Anatole
    public function testAddTeenTwiceThrows()
    {
        $this->expectException(\Exception::class);
        $fm = new FamilyManager();
        $fm->addTeen('Galyst', 1.0);
        $fm->addTeen('Galyst', 2.0);
    }

    // Anatole
    public function testUnknownTeenThrows()
    {
        $this->expectException(\Exception::class);
        $fm = new FamilyManager();
        $fm->getWallet('Pierre');
    }
}
