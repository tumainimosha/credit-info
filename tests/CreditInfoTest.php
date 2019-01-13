<?php

namespace CreditInfo\Tests;

use CreditInfo\CreditInfoServiceProvider;
use CreditInfo\Facades\CreditInfo;
use Orchestra\Testbench\TestCase;

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
