<?php

namespace App\Presentation\Services;

class ViewService
{
    public function render(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . "/../../../templates/{$view}.php";
    }
}
