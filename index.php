<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controller;
use App\FamilyManager;
use App\ViewHelper;

session_start();

if (!isset($_SESSION['familyManager'])) {
    $_SESSION['familyManager'] = new FamilyManager();
}

$controller = new Controller($_SESSION['familyManager']);
$controller->handleRequest();

$fm = $controller->getFamilyManager();
$teens = $fm->getAllTeens();
$messageData = $controller->getMessage();
$message = $messageData['text'];
$messageType = $messageData['type'];
$stats = ViewHelper::calculateStatistics($fm, $teens);

extract($stats);

$title = 'MyWeeklyAllowance - Manage Teens\' Pocket Money';
include __DIR__ . '/templates/partials/header.php';
?>

<div class="container">
    <?php include __DIR__ . '/templates/partials/sidebar.php'; ?>
    <?php include __DIR__ . '/templates/partials/main.php'; ?>
</div>

<?php include __DIR__ . '/templates/partials/footer.php'; ?>
