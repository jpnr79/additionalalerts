<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use GlpiPlugin\Additionalalerts\InkAlert;

class InkAlertTest extends TestCase
{
    public function testGetTypeName(): void
    {
        $inkAlert = new InkAlert();
        $this->assertIsString($inkAlert->getTypeName(1));
    }

    public function testGetIcon(): void
    {
        $inkAlert = new InkAlert();
        $this->assertIsString($inkAlert->getIcon());
    }
}
