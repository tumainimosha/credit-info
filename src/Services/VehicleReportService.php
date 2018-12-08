<?php

namespace Princeton255\CreditInfo\Services;

use Illuminate\Support\Facades\Cache;
use Princeton255\CreditInfo\Exceptions\DataNotFoundException;
use Princeton255\CreditInfo\Exceptions\Exception;
use Princeton255\CreditInfo\WsClient;

class VehicleReportService
{
    /**
     * @var WsClient
     */
    private $client;

    /**
     * @param WsClient $client
     */
    public function __construct(WsClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param $registration
     * @return mixed
     * @throws DataNotFoundException
     * @throws Exception
     */
    public function __invoke($registration)
    {
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

    /**
     * @param $registration
     * @return array
     * @throws DataNotFoundException
     * @throws Exception
     */
    public function getDetails($registration): array
    {
        $xml = "<ns1:request><request><RegistrationNumber>$registration</RegistrationNumber></request></ns1:request>";
        $request_attr = new \SoapVar($xml, \XSD_ANYXML);

        $request = [
            'name' => 'VehicleCheckReport',
            'request' => $request_attr,
        ];

        logger('Credit Info Request: ' . print_r($request, true));

        $response = $this->client->__call('GetExternalReport', [$request]);

        logger('Credit Info Response: ' . print_r($response, true));

        if (!isset($response->GetExternalReportResult) || !isset($response->GetExternalReportResult->any)
        ) {
            throw new Exception('Error verifying Vehicle number. Please try again later, or contact our support line.');
        }

        $xml_string = $response->GetExternalReportResult->any;

        $xml = new \SimpleXMLElement($xml_string);

        // Check for response status in header
        if ((string) $xml->Header->Status !== 'DataFound') {
            $msg = 'No data found for given Vehicle number! Please verify your details and try again';
            logger($msg);
            throw new DataNotFoundException($msg);
        }

        return json_decode(json_encode($xml), true);
    }
}
