<?php

namespace CreditInfo\Services;

use CreditInfo\Exceptions\DataNotFoundException;
use CreditInfo\Exceptions\Exception;
use Illuminate\Support\Facades\Cache;

class VehicleReportService extends GetExternalReportService
{
    protected function getRequestName(): string
    {
        return 'VehicleCheckReport';
    }

    protected function getRequestParameterName(): string
    {
        return 'RegistrationNumber';
    }
}
