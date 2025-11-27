<?php

namespace App;

class FamilyManager
{
    private array $wallets = [];

    public function addTeen(string $name, float $weeklyAllowance): void
    {
        if (isset($this->wallets[$name])) {
            throw new \Exception("L'adolescent '$name' existe déjà");
        }
        $this->wallets[$name] = new Wallet($weeklyAllowance);
    }

    public function getWallet(string $name): Wallet
    {
        if (!isset($this->wallets[$name])) {
            throw new \Exception("Adolescent '$name' non trouvé");
        }
        return $this->wallets[$name];
    }

    public function depositToTeen(string $name, float $amount): void
    {
        $this->getWallet($name)->deposit($amount);
    }

    public function spendFromTeen(string $name, float $amount, string $description = ""): void
    {
        $this->getWallet($name)->spend($amount, $description);
    }

    public function processAllWeeklyAllowances(): void
    {
        foreach ($this->wallets as $wallet) {
            $wallet->processWeeklyAllowance();
        }
    }

    public function getAllTeens(): array
    {
        return array_keys($this->wallets);
    }
}