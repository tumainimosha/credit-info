<?php

namespace CreditInfo\Services;

use CreditInfo\Exceptions\DataNotFoundException;
use CreditInfo\Exceptions\Exception;
use Illuminate\Support\Facades\Cache;

class VehicleReportService extends GetExternalReportService
{
    /**
     * @param $registration
     * @return array
     * @throws DataNotFoundException
     * @throws Exception
     */
    public function __invoke($registration): array
    {
        $registration = preg_replace('/[^a-zA-Z0-9]/', '', strtolower(trim($registration))); //sanitize

        logger('Fetching Vehicle Details for registration: ' . $registration);

        $cache_key = config('credit-info.cache_prefix') . 'vehicle-info:' . $registration;
        $cache_ttl = config('credit-info.cache_response_ttl');

        $details = Cache::remember(
            $cache_key,
            $cache_ttl,
            function () use ($registration) {
                return $this->getDetails($registration);
            }
        );

        logger('Vehicle details found!', $details);

        return array_get($details, 'ReportDetail');
    }

    protected function getRequestName(): string
    {
        return 'VehicleCheckReport';
    }

    protected function getRequestParameterName(): string
    {
        return 'RegistrationNumber';
    }
}
