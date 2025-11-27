<?php

namespace App;

class ViewHelper
{
    public static function calculateStatistics(FamilyManager $fm, array $teens): array
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

    public static function renderView(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . "/../templates/{$view}.php";
    }
}
