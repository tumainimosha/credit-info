<?php

namespace CreditInfo\Facades;

use Illuminate\Support\Facades\Facade;

class CreditInfo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'credit-info';
    }
}
