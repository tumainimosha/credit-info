<?php

namespace CreditInfo\Services;

use CreditInfo\Exceptions\InvalidReferenceNumberException;

class NationalIdReportService extends GetExternalReportService
{
    protected function getRequestName(): string
    {
        return 'FullDemographicReport';
    }

    protected function getRequestParameterName(): string
    {
        return 'NationalId';
    }

    /**
     * @param string $reference
     * @return array
     * @throws InvalidReferenceNumberException
     */
    protected function prepareRequest(string $reference): array
    {
        if (!preg_match('#^[0-9]{20}$#', $reference)) {
            throw new InvalidReferenceNumberException('Invalid National ID number. National Id consists of 20 numbers only');
        }

        return parent::prepareRequest($reference);
    }
}
