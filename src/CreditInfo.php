<?php

namespace CreditInfo;

use CreditInfo\Services\DrivingLicenseReportService;
use CreditInfo\Services\NationalIdReportService;
use CreditInfo\Services\VehicleReportService;

class CreditInfo
{
    /**
     * @param string $registration
     * @return array
     * @throws Exceptions\DataNotFoundException
     * @throws Exceptions\Exception
     */
    public function getVehicleReport(string $registration): array 
    {
        /** @var VehicleReportService $vehicleReportService */
        $vehicleReportService = app(VehicleReportService::class);

        return $vehicleReportService($registration);
    }

    /**
     * @param string $license_no
     * @return array
     * @throws Exceptions\InvalidReferenceNumberException
     * @throws Exceptions\DataNotFoundException
     * @throws Exceptions\Exception
     */
    public function getDrivingLicenseReport(string $license_no): array
    {
        /** @var DrivingLicenseReportService $service */
        $service = app(DrivingLicenseReportService::class);

        return $service($license_no);
    }

    /**
     * @param string $id_number
     * @return array
     * @throws Exceptions\InvalidReferenceNumberException
     * @throws Exceptions\DataNotFoundException
     * @throws Exceptions\Exception
     */
    public function getNationalIdReport(string $id_number): array
    {
        /** @var DrivingLicenseReportService $service */
        $service = app(NationalIdReportService::class);

        return $service($id_number);
    }
}
