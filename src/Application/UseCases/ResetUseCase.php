<?php

namespace App\Application\UseCases;

use App\Domain\Services\FamilyManager;

class ResetUseCase
{
    public function execute(): FamilyManager
    {
        return new FamilyManager();
    }
}
