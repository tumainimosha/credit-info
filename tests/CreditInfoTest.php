<?php

namespace Princeton255\CreditInfo\Tests;

use Orchestra\Testbench\TestCase;
use Princeton255\CreditInfo\CreditInfoServiceProvider;
use Princeton255\CreditInfo\Facades\CreditInfo;

class CreditInfoTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [CreditInfoServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'credit-info' => CreditInfo::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
