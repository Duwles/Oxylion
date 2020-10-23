<?php
namespace Tests\Oxylion\Component\Application;

use Oxylion\Component\Application\Application;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testSingleton() {
        $callFirstApp  = Application::make();
        $callSecondApp = Application::make();

        $this->assertInstanceOf(Application::class, $callFirstApp);
        $this->assertSame($callFirstApp, $callSecondApp);
    }
}