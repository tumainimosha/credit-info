<?php

namespace CreditInfo\Exceptions;

class TimeoutException extends Exception
{
    protected $message = 'Read timeout while fetching data from CreditInfo';
}
