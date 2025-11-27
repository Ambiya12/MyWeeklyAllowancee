<?php

namespace App\Presentation\Services;

use App\Domain\Services\FamilyManager;

class StatisticsService
{
    public function calculateStatistics(FamilyManager $fm, array $teens): array
    {
        $totalBalance = 0;
        $totalSpent = 0;

        foreach ($teens as $teen) {
            $wallet = $fm->getWallet($teen);
            $totalBalance += $wallet->getBalance();
            
            foreach ($wallet->getHistory() as $transaction) {
                $totalSpent += $transaction['amount'];
            }
        }

        return [
            'totalBalance' => $totalBalance,
            'totalSpent' => $totalSpent,
        ];
    }
}
