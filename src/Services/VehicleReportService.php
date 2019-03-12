<?php

namespace CreditInfo\Services;

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
