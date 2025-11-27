<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Domain\Services\FamilyManager;
use App\Infrastructure\Http\TeenController;
use App\Application\UseCases\AddTeenUseCase;
use App\Application\UseCases\DepositUseCase;
use App\Application\UseCases\SpendUseCase;
use App\Application\UseCases\ProcessAllowanceUseCase;
use App\Application\UseCases\ResetUseCase;
use App\Presentation\Services\StatisticsService;

session_start();

if (!isset($_SESSION['familyManager'])) {
    $_SESSION['familyManager'] = new FamilyManager();
}

$familyManager = $_SESSION['familyManager'];

$addTeenUseCase = new AddTeenUseCase($familyManager);
$depositUseCase = new DepositUseCase($familyManager);
$spendUseCase = new SpendUseCase($familyManager);
$processAllowanceUseCase = new ProcessAllowanceUseCase($familyManager);
$resetUseCase = new ResetUseCase();

$controller = new TeenController(
    $addTeenUseCase,
    $depositUseCase,
    $spendUseCase,
    $processAllowanceUseCase,
    $resetUseCase,
    $familyManager
);

$controller->handleRequest();

$fm = $controller->getFamilyManager();
$teens = $fm->getAllTeens();
$messageData = $controller->getMessage();
$message = $messageData['text'];
$messageType = $messageData['type'];

$statisticsService = new StatisticsService();
$stats = $statisticsService->calculateStatistics($fm, $teens);

extract($stats);

$title = 'MyWeeklyAllowance - Manage Teens\' Pocket Money';
include __DIR__ . '/templates/partials/header.php';
?>

<div class="container">
    <?php include __DIR__ . '/templates/partials/sidebar.php'; ?>
    <?php include __DIR__ . '/templates/partials/main.php'; ?>
</div>

<?php include __DIR__ . '/templates/partials/footer.php'; ?>
