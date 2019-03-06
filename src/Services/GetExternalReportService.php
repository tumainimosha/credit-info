<?php

namespace CreditInfo\Services;

use CreditInfo\Exceptions\DataNotFoundException;
use CreditInfo\Exceptions\Exception;
use CreditInfo\Exceptions\InvalidReferenceNumberException;
use CreditInfo\Exceptions\TimeoutException;
use CreditInfo\WsClient;
use Illuminate\Support\Facades\Cache;

abstract class GetExternalReportService
{
    /**
     * @var WsClient
     */
    protected $client;

    abstract protected function getRequestName(): string;

    abstract protected function getRequestParameterName(): string;

    /**
     * @param WsClient $client
     */
    public function __construct(WsClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param $reference
     * @return array
     * @throws InvalidReferenceNumberException
     * @throws DataNotFoundException
     * @throws Exception
     */
    public function __invoke($reference): array
    {
        $class_name = $this->getClassName();

        $reference = preg_replace('/[^a-zA-Z0-9]/', '', strtolower(trim($reference))); //sanitize

        logger("Fetching $class_name for reference: $reference");

        $cache_key = config('credit-info.cache_prefix') . $class_name . $reference;
        $cache_ttl = config('credit-info.cache_response_ttl');

        $details = Cache::remember(
            $cache_key,
            now()->addMinutes($cache_ttl),
            function () use ($reference) {
                return $this->getDetails($reference);
            }
        );

        logger("$class_name details found!", $details);

        return array_get($details, 'ReportDetail');
    }

    /**
     * @param $registration
     * @return array
     * @throws DataNotFoundException
     * @throws Exception
     * @throws TimeoutException
     */
    public function getDetails($registration): array
    {
        $request = $this->prepareRequest($registration);

        logger('Credit Info Request: ' . print_r($request, true));

        $response = $this->client->__call('GetExternalReport', [$request]);

        logger('Credit Info Response: ' . print_r($response, true));

        return $this->parseResponse($response);
    }

    /**
     * @param $reference
     * @return array
     */
    protected function prepareRequest($reference): array
    {
        $request_name = $this->getRequestName();
        $request_param = $this->getRequestParameterName();

        $xml = "<ns1:request><request><$request_param>$reference</$request_param></request></ns1:request>";
        $request_attr = new \SoapVar($xml, \XSD_ANYXML);

        $request = [
            'name' => $request_name,
            'request' => $request_attr,
        ];

        return $request;
    }

    /**
     * @param $response
     * @return array
     * @throws DataNotFoundException
     * @throws Exception
     * @throws TimeoutException
     */
    protected function parseResponse($response): array
    {
        $response_xml = $response->GetExternalReportResult->any;
        $response_xml = new \SimpleXMLElement($response_xml);

        $responseHeader = $this->getResponseHeaderName();

        switch ((string) $response_xml->$responseHeader->Status) {
            // Timeout
            case 'Timeout':
                throw new TimeoutException($response_xml->Header->ErrorMessage);

            // Data Not Found
            case 'DataNotFound':
                throw new DataNotFoundException();

            // Success
            case 'DataFound':
                return json_decode(json_encode($response_xml), true);

            // Error
            case 'Error':
            default:
                throw new Exception($response_xml->Header->ErrorMessage ?? null);
        }
    }

    protected function getClassName()
    {
        $path = explode('\\', __CLASS__);

        return array_pop($path);
    }

    protected function getResponseHeaderName(): string
    {
        return 'Header';
    }
}
