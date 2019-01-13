<?php

namespace CreditInfo;

use CreditInfo\Services\VehicleReportService;

class CreditInfo
{
    /**
     * @param $registration
     * @return array
     * @throws Exceptions\DataNotFoundException
     * @throws Exceptions\Exception
     */
    public function getVehicleReport($registration)
    {
        /** @var VehicleReportService $vehicleReportService */
        $vehicleReportService = app(VehicleReportService::class);

        return $vehicleReportService($registration);
    }
}
