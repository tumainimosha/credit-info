<?php

namespace CreditInfo;

use CreditInfo\Services\DrivingLicenseReportService;
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

    /**
     * @param $license_no
     * @return array
     * @throws Exceptions\InvalidReferenceNumberException
     * @throws Exceptions\DataNotFoundException
     * @throws Exceptions\Exception
     */
    public function getDrivingLicenseReport($license_no)
    {
        /** @var DrivingLicenseReportService $service */
        $service = app(DrivingLicenseReportService::class);

        return $service($license_no);
    }

    /**
     * @param $id_number
     * @return array
     * @throws Exceptions\InvalidReferenceNumberException
     * @throws Exceptions\DataNotFoundException
     * @throws Exceptions\Exception
     */
    public function getNationalIdReport($id_number)
    {
        /** @var DrivingLicenseReportService $service */
        $service = app(DrivingLicenseReportService::class);

        return $service($id_number);
    }
}
