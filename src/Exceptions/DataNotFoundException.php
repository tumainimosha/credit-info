<?php

namespace CreditInfo\Exceptions;

class DataNotFoundException extends Exception
{
    protected $message = 'No data found for given reference number! Please verify your details and try again';
}
