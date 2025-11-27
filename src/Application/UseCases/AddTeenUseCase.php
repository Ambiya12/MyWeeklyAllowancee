<?php

namespace App\Application\UseCases;

use App\FamilyManager;

class AddTeenUseCase
{
    private FamilyManager $familyManager;

    public function __construct(FamilyManager $familyManager)
    {
        $this->familyManager = $familyManager;
    }

    public function execute(string $name, float $amount): void
    {
        if (empty(trim($name))) {
            throw new \RuntimeException('Please provide a teen\'s name');
        }

        $this->familyManager->addTeen($name, $amount);
    }
}
