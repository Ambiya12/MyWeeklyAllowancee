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
}
