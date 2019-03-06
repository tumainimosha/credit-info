<?php

namespace CreditInfo\Services;

use CreditInfo\Exceptions\InvalidReferenceNumberException;

class DrivingLicenseReportService extends GetExternalReportService
{
    /**
     * @param $reference
     * @return array
     * @throws InvalidReferenceNumberException
     */
    protected function prepareRequest($reference): array
    {
        if (!preg_match('#^[0-9]{10}$#', $reference)) {
            throw new InvalidReferenceNumberException('Invalid Driving License number. Driving License number consists of 10 numbers only');
        }

        return parent::prepareRequest($reference);
    }

    protected function getRequestName(): string
    {
        return 'DrivingLicenseReport';
    }

    protected function getRequestParameterName(): string
    {
        return 'DrivingLicenseNumber';
    }
}
