<?php

namespace App\Application\UseCases;

use App\FamilyManager;

class ResetUseCase
{
    public function execute(): FamilyManager
    {
        return new FamilyManager();
    }
}
