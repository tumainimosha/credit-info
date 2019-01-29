<?php

namespace CreditInfo\Services;

use CreditInfo\Exceptions\DataNotFoundException;
use CreditInfo\Exceptions\Exception;
use CreditInfo\Exceptions\InvalidReferenceNumberException;
use Illuminate\Support\Facades\Cache;

class DrivingLicenseReportService extends GetExternalReportService
{
    /**
     * @param $license_no
     * @return array
     * @throws InvalidReferenceNumberException
     * @throws DataNotFoundException
     * @throws Exception
     */
    public function __invoke($license_no): array
    {
        $license_no = preg_replace('/[^a-zA-Z0-9]/', '', strtolower(trim($license_no))); //sanitize

        logger('Fetching Driving License Details for license number: ' . $license_no);

        $cache_key = config('credit-info.cache_prefix') . 'driving-license:' . $license_no;
        $cache_ttl = config('credit-info.cache_response_ttl');

        $details = Cache::remember(
            $cache_key,
            $cache_ttl,
            function () use ($license_no) {
                return $this->getDetails($license_no);
            }
        );

        logger('Driving license details found!', $details);

        return array_get($details, 'ReportDetail');
    }

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
