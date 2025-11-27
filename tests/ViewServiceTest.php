<?php

namespace MyWeeklyAllowancee\tests;

use PHPUnit\Framework\TestCase;
use App\Presentation\Services\ViewService;

class ViewServiceTest extends TestCase
{
    private ViewService $service;

    protected function setUp(): void
    {
        $this->service = new ViewService();
    }

    public function testRenderMethodExists(): void
    {
        $this->assertTrue(method_exists($this->service, 'render'));
    }

    public function testViewServiceCanBeInstantiated(): void
    {
        $service = new ViewService();
        $this->assertInstanceOf(ViewService::class, $service);
    }
}
