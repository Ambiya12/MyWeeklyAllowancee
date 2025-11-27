<?php

namespace App;

class Wallet
{
    private float $balance = 0.0;
    private float $weeklyAllowance;
    private array $history = [];

    public function __construct(float $weeklyAllowance = 0.0)
    {
        $this->weeklyAllowance = $weeklyAllowance;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function deposit(float $amount): void
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException("Le montant du dépôt ne peut pas être négatif");
        }
        $this->balance += $amount;
    }

    public function spend(float $amount, string $description = ""): void
    {
        if ($amount > $this->balance) {
            throw new \Exception("Fonds insuffisants");
        }

        $this->balance -= $amount;

        $this->history[] = [
            'amount' => $amount,
            'description' => $description,
            'date' => new \DateTime()
        ];
    }

    public function processWeeklyAllowance(): void
    {
        $this->balance += $this->weeklyAllowance;
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    public function setAllowance(float $amount): void
    {
        $this->weeklyAllowance = $amount;
    }

    public function getAllowance(): float
    {
        return $this->weeklyAllowance;
    }
}
