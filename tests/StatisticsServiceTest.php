<?php

namespace MyWeeklyAllowancee\tests;

use PHPUnit\Framework\TestCase;
use App\Domain\Services\FamilyManager;
use App\Presentation\Services\StatisticsService;

class StatisticsServiceTest extends TestCase
{
    private FamilyManager $familyManager;
    private StatisticsService $service;

    protected function setUp(): void
    {
        $this->familyManager = new FamilyManager();
        $this->service = new StatisticsService();
    }

    public function testCalculateStatisticsWithNoTeens(): void
    {
        $stats = $this->service->calculateStatistics($this->familyManager, []);
        
        $this->assertEquals(0, $stats['totalBalance']);
        $this->assertEquals(0, $stats['totalSpent']);
    }

    public function testCalculateStatisticsWithOneTeen(): void
    {
        $this->familyManager->addTeen('Anatole', 10.0);
        $this->familyManager->depositToTeen('Anatole', 50.0);
        $this->familyManager->spendFromTeen('Anatole', 15.0, 'Lunch');
        
        $stats = $this->service->calculateStatistics($this->familyManager, ['Anatole']);
        
        $this->assertSame(35.0, $stats['totalBalance']);
        $this->assertSame(15.0, $stats['totalSpent']);
    }

    public function testCalculateStatisticsWithMultipleTeens(): void
    {
        $this->familyManager->addTeen('Anatole', 10.0);
        $this->familyManager->addTeen('Galyst', 15.0);
        $this->familyManager->addTeen('Antoine', 20.0);
        
        $this->familyManager->depositToTeen('Anatole', 100.0);
        $this->familyManager->depositToTeen('Galyst', 50.0);
        $this->familyManager->depositToTeen('Antoine', 75.0);
        
        $this->familyManager->spendFromTeen('Anatole', 20.0, 'Cinema');
        $this->familyManager->spendFromTeen('Galsyt', 10.0, 'Snacks');
        $this->familyManager->spendFromTeen('Antoine', 25.0, 'Books');
        
        $stats = $this->service->calculateStatistics($this->familyManager, ['Anatole', 'Galyst', 'Antoine']);
        
        $this->assertSame(170.0, $stats['totalBalance']);
        $this->assertSame(55.0, $stats['totalSpent']);
    }

    public function testCalculateStatisticsWithMultipleTransactions(): void
    {
        $this->familyManager->addTeen('David', 10.0);
        $this->familyManager->depositToTeen('David', 100.0);
        
        $this->familyManager->spendFromTeen('David', 10.0, 'Coffee');
        $this->familyManager->spendFromTeen('David', 15.0, 'Lunch');
        $this->familyManager->spendFromTeen('David', 20.0, 'Movie');
        
        $stats = $this->service->calculateStatistics($this->familyManager, ['David']);
        
        $this->assertSame(55.0, $stats['totalBalance']);
        $this->assertSame(45.0, $stats['totalSpent']);
    }

    public function testCalculateStatisticsWithTeenHavingNoBalance(): void
    {
        $this->familyManager->addTeen('Eve', 10.0);
        
        $stats = $this->service->calculateStatistics($this->familyManager, ['Eve']);
        
        $this->assertEquals(0, $stats['totalBalance']);
        $this->assertEquals(0, $stats['totalSpent']);
    }

    public function testCalculateStatisticsWithMixedBalances(): void
    {
        $this->familyManager->addTeen('Frank', 10.0);
        $this->familyManager->addTeen('Grace', 15.0);
        
        $this->familyManager->depositToTeen('Frank', 50.0);
        
        $this->familyManager->spendFromTeen('Frank', 10.0, 'Test');
        
        $stats = $this->service->calculateStatistics($this->familyManager, ['Frank', 'Grace']);
        
        $this->assertSame(40.0, $stats['totalBalance']);
        $this->assertSame(10.0, $stats['totalSpent']);
    }
}