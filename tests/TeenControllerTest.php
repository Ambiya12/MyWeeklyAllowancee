<?php

namespace MyWeeklyAllowancee\tests;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Http\TeenController;
use App\Application\UseCases\AddTeenUseCase;
use App\Application\UseCases\DepositUseCase;
use App\Application\UseCases\SpendUseCase;
use App\Application\UseCases\ProcessAllowanceUseCase;
use App\Application\UseCases\ResetUseCase;
use App\Domain\Services\FamilyManager;

class TeenControllerTest extends TestCase
{
    private FamilyManager $familyManager;
    private TeenController $controller;

    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->familyManager = new FamilyManager();
        
        $addTeenUseCase = new AddTeenUseCase($this->familyManager);
        $depositUseCase = new DepositUseCase($this->familyManager);
        $spendUseCase = new SpendUseCase($this->familyManager);
        $processAllowanceUseCase = new ProcessAllowanceUseCase($this->familyManager);
        $resetUseCase = new ResetUseCase();

        $this->controller = new TeenController(
            $addTeenUseCase,
            $depositUseCase,
            $spendUseCase,
            $processAllowanceUseCase,
            $resetUseCase,
            $this->familyManager
        );
    }

    protected function tearDown(): void
    {
        unset($_SESSION['message']);
        unset($_SESSION['messageType']);
        unset($_POST);
        unset($_SERVER['REQUEST_METHOD']);
    }

    public function testGetFamilyManager(): void
    {
        $fm = $this->controller->getFamilyManager();
        $this->assertInstanceOf(FamilyManager::class, $fm);
    }

    public function testGetMessageWhenNoMessageSet(): void
    {
        $message = $this->controller->getMessage();
        
        $this->assertIsArray($message);
        $this->assertArrayHasKey('text', $message);
        $this->assertArrayHasKey('type', $message);
        $this->assertSame('', $message['text']);
        $this->assertSame('info', $message['type']);
    }

    public function testGetMessageReturnsAndClearsSessionMessage(): void
    {
        $_SESSION['message'] = 'Test message';
        $_SESSION['messageType'] = 'success';
        
        $message = $this->controller->getMessage();
        
        $this->assertSame('Test message', $message['text']);
        $this->assertSame('success', $message['type']);
        
        $this->assertArrayNotHasKey('message', $_SESSION);
        $this->assertArrayNotHasKey('messageType', $_SESSION);
    }

    public function testControllerCanBeInstantiated(): void
    {
        $this->assertInstanceOf(TeenController::class, $this->controller);
    }

    public function testHandleRequestWithGetRequest(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        
        $this->controller->handleRequest();
        
        $this->assertTrue(true);
    }
}
