<?php

namespace MyWeeklyAllowancee\tests;

use PHPUnit\Framework\TestCase;
use App\Domain\Services\FamilyManager;
use App\Application\UseCases\AddTeenUseCase;
use App\Application\UseCases\DepositUseCase;
use App\Application\UseCases\SpendUseCase;
use App\Application\UseCases\ProcessAllowanceUseCase;
use App\Application\UseCases\ResetUseCase;
use RuntimeException;

// Galystan, Anatole et Antoine
class UseCasesTest extends TestCase
{
    private FamilyManager $familyManager;

    protected function setUp(): void
    {
        $this->familyManager = new FamilyManager();
    }

    public function testAddTeenUseCaseExecutesSuccessfully(): void
    {
        $useCase = new AddTeenUseCase($this->familyManager);
        $useCase->execute('Anatole', 10.0);

        $wallet = $this->familyManager->getWallet('Anatole');
        $this->assertSame(0.0, $wallet->getBalance());
        $this->assertSame(10.0, $wallet->getAllowance());
    }

    public function testAddTeenUseCaseThrowsExceptionForEmptyName(): void
    {
        $useCase = new AddTeenUseCase($this->familyManager);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Please provide a teen\'s name');
        $useCase->execute('', 10.0);
    }

    public function testAddTeenUseCaseThrowsExceptionForWhitespaceName(): void
    {
        $useCase = new AddTeenUseCase($this->familyManager);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Please provide a teen\'s name');
        $useCase->execute('   ', 10.0);
    }

    public function testDepositUseCaseExecutesSuccessfully(): void
    {
        $this->familyManager->addTeen('Ben', 5.0);
        $useCase = new DepositUseCase($this->familyManager);

        $useCase->execute('Ben', 50.0);

        $wallet = $this->familyManager->getWallet('Ben');
        $this->assertSame(50.0, $wallet->getBalance());
    }

    public function testDepositUseCaseThrowsExceptionForEmptyName(): void
    {
        $useCase = new DepositUseCase($this->familyManager);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Please select a teen');
        $useCase->execute('', 50.0);
    }

    public function testDepositUseCaseThrowsExceptionForZeroAmount(): void
    {
        $this->familyManager->addTeen('Ben', 5.0);
        $useCase = new DepositUseCase($this->familyManager);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Amount must be greater than 0');
        $useCase->execute('Ben', 0);
    }

    public function testDepositUseCaseThrowsExceptionForNegativeAmount(): void
    {
        $this->familyManager->addTeen('Ben', 5.0);
        $useCase = new DepositUseCase($this->familyManager);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Amount must be greater than 0');
        $useCase->execute('Ben', -10.0);
    }

    public function testSpendUseCaseExecutesSuccessfully(): void
    {
        $this->familyManager->addTeen('Bob', 5.0);
        $this->familyManager->depositToTeen('Bob', 100.0);

        $useCase = new SpendUseCase($this->familyManager);
        $useCase->execute('Bob', 30.0, 'Cinema');

        $wallet = $this->familyManager->getWallet('Bob');
        $this->assertSame(70.0, $wallet->getBalance());
    }

    public function testSpendUseCaseExecutesWithoutDescription(): void
    {
        $this->familyManager->addTeen('Bob', 5.0);
        $this->familyManager->depositToTeen('Bob', 100.0);

        $useCase = new SpendUseCase($this->familyManager);
        $useCase->execute('Bob', 30.0);

        $wallet = $this->familyManager->getWallet('Bob');
        $this->assertSame(70.0, $wallet->getBalance());
    }

    public function testSpendUseCaseThrowsExceptionForEmptyName(): void
    {
        $useCase = new SpendUseCase($this->familyManager);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Please select a teen');
        $useCase->execute('', 30.0);
    }

    public function testSpendUseCaseThrowsExceptionForZeroAmount(): void
    {
        $this->familyManager->addTeen('Bob', 5.0);
        $useCase = new SpendUseCase($this->familyManager);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Amount must be greater than 0');
        $useCase->execute('Bob', 0);
    }

    public function testSpendUseCaseThrowsExceptionForNegativeAmount(): void
    {
        $this->familyManager->addTeen('Bob', 5.0);
        $useCase = new SpendUseCase($this->familyManager);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Amount must be greater than 0');
        $useCase->execute('Bob', -10.0);
    }

    public function testProcessAllowanceUseCaseExecutesSuccessfully(): void
    {
        $this->familyManager->addTeen('Alice', 15.0);
        $this->familyManager->addTeen('Charlie', 20.0);

        $useCase = new ProcessAllowanceUseCase($this->familyManager);
        $useCase->execute();

        $this->assertSame(15.0, $this->familyManager->getWallet('Alice')->getBalance());
        $this->assertSame(20.0, $this->familyManager->getWallet('Charlie')->getBalance());
    }

    public function testProcessAllowanceUseCaseExecutesMultipleTimes(): void
    {
        $this->familyManager->addTeen('Alice', 15.0);

        $useCase = new ProcessAllowanceUseCase($this->familyManager);
        $useCase->execute();
        $useCase->execute();

        $this->assertSame(30.0, $this->familyManager->getWallet('Alice')->getBalance());
    }

    public function testResetUseCaseReturnsNewFamilyManager(): void
    {
        $useCase = new ResetUseCase();
        $newManager = $useCase->execute();

        $this->assertInstanceOf(FamilyManager::class, $newManager);
        $this->assertEmpty($newManager->getAllTeens());
    }

    public function testResetUseCaseReturnsIndependentInstance(): void
    {
        $useCase = new ResetUseCase();
        $manager1 = $useCase->execute();
        $manager2 = $useCase->execute();

        $manager1->addTeen('Test', 10.0);

        $this->assertNotEmpty($manager1->getAllTeens());
        $this->assertEmpty($manager2->getAllTeens());
    }
}
