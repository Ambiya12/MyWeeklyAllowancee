<?php

namespace App\Application\UseCases;

use App\FamilyManager;

class SpendUseCase
{
    private FamilyManager $familyManager;

    public function __construct(FamilyManager $familyManager)
    {
        $this->familyManager = $familyManager;
    }

    public function execute(string $teenName, float $amount, string $description = ''): void
    {
        if (empty($teenName)) {
            throw new \RuntimeException('Please select a teen');
        }

        if ($amount <= 0) {
            throw new \RuntimeException('Amount must be greater than 0');
        }

        $this->familyManager->spendFromTeen($teenName, $amount, $description);
    }
}
