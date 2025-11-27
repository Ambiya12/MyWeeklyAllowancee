<?php

namespace App\Infrastructure\Http;

use App\Application\UseCases\AddTeenUseCase;
use App\Application\UseCases\DepositUseCase;
use App\Application\UseCases\SpendUseCase;
use App\Application\UseCases\ProcessAllowanceUseCase;
use App\Application\UseCases\ResetUseCase;
use App\Domain\Services\FamilyManager;

class TeenController
{
    private AddTeenUseCase $addTeenUseCase;
    private DepositUseCase $depositUseCase;
    private SpendUseCase $spendUseCase;
    private ProcessAllowanceUseCase $processAllowanceUseCase;
    private ResetUseCase $resetUseCase;
    private FamilyManager $familyManager;

    public function __construct(
        AddTeenUseCase $addTeenUseCase,
        DepositUseCase $depositUseCase,
        SpendUseCase $spendUseCase,
        ProcessAllowanceUseCase $processAllowanceUseCase,
        ResetUseCase $resetUseCase,
        FamilyManager $familyManager
    ) {
        $this->addTeenUseCase = $addTeenUseCase;
        $this->depositUseCase = $depositUseCase;
        $this->spendUseCase = $spendUseCase;
        $this->processAllowanceUseCase = $processAllowanceUseCase;
        $this->resetUseCase = $resetUseCase;
        $this->familyManager = $familyManager;
    }

    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            try {
                switch ($action) {
                    case 'add':
                        $this->handleAdd();
                        break;
                    case 'deposit':
                        $this->handleDeposit();
                        break;
                    case 'spend':
                        $this->handleSpend();
                        break;
                    case 'allowance':
                        $this->handleAllowance();
                        break;
                    case 'reset':
                        $this->handleReset();
                        break;
                    default:
                        $this->setMessage('Unknown action', 'error');
                }
            } catch (\Exception $e) {
                $this->setMessage($e->getMessage(), 'error');
            }

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    private function handleAdd(): void
    {
        $name = trim($_POST['name'] ?? '');
        $amount = floatval($_POST['amount'] ?? 0);

        $this->addTeenUseCase->execute($name, $amount);
        $this->setMessage("Teen '{$name}' has been added successfully!", 'success');
    }

    private function handleDeposit(): void
    {
        $name = $_POST['name'] ?? '';
        $amount = floatval($_POST['amount'] ?? 0);

        $this->depositUseCase->execute($name, $amount);
        $this->setMessage("Deposited {$amount}€ to {$name}'s wallet", 'success');
    }

    private function handleSpend(): void
    {
        $name = $_POST['name'] ?? '';
        $amount = floatval($_POST['amount'] ?? 0);
        $description = trim($_POST['description'] ?? '');

        $this->spendUseCase->execute($name, $amount, $description);
        $this->setMessage("{$name} spent {$amount}€" . ($description ? " on {$description}" : ''), 'success');
    }

    private function handleAllowance(): void
    {
        $this->processAllowanceUseCase->execute();
        $this->setMessage('Weekly allowances have been processed for all teens', 'success');
    }

    private function handleReset(): void
    {
        $_SESSION['familyManager'] = $this->resetUseCase->execute();
        $this->familyManager = $_SESSION['familyManager'];
        $this->setMessage('All data has been reset', 'info');
    }

    private function setMessage(string $message, string $type = 'info'): void
    {
        $_SESSION['message'] = $message;
        $_SESSION['messageType'] = $type;
    }

    public function getMessage(): array
    {
        $message = $_SESSION['message'] ?? '';
        $type = $_SESSION['messageType'] ?? 'info';

        unset($_SESSION['message']);
        unset($_SESSION['messageType']);

        return [
            'text' => $message,
            'type' => $type
        ];
    }

    public function getFamilyManager(): FamilyManager
    {
        return $this->familyManager;
    }
}
