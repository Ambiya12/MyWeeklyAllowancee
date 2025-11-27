<?php

namespace App\Application\UseCases;

use App\Domain\Services\FamilyManager;

class ProcessAllowanceUseCase
{
    private FamilyManager $familyManager;

    public function __construct(FamilyManager $familyManager)
    {
        $this->familyManager = $familyManager;
    }

    public function execute(): void
    {
        $this->familyManager->processAllWeeklyAllowances();
    }
}
