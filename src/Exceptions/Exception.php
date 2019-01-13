<?php

namespace CreditInfo\Exceptions;

use Exception as BaseException;

class Exception extends BaseException
{
    protected $message = 'Error while fetching data from CreditInfo';
}
