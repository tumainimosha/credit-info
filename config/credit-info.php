<?php

return [

    /**
     * username and password shared during integration.
     */
    'username' => env('CREDIT_INFO_USERNAME'),
    'password' => env('CREDIT_INFO_PASSWORD'),

    /*
     * wsdl url for credit info webservice.
     */
    'wsdl_url' => env('CREDIT_INFO_WSDL', 'https://ws.creditinfo.co.tz/WsReport/v5.39/service.svc?wsdl'),

    /**
     * Control WSDL_CACHE option of SoapClient. During development you may
     * disable caching to debug certain errors. However, in production
     * it is advisable to cache the wsdl file for performance.
     */
    'cache_wsdl' => env('CREDIT_INFO_CACHE_WSDL', true),

    /**
     * Cache webservice successful response for `cache_response_ttl` minutes.
     * Set to zero to disable response caching. Response caching speeds
     * up subsequent request for same details by fetching them
     * from local cache instead of over the network.
     *
     * Default set to 1 day (1440 minutes)
     */
    'cache_response_ttl' => env('CREDIT_INFO_CACHE_TTL', 1440),

    /**
     * Prefix used for cache keys created by package.
     */
    'cache_prefix' => env('CREDIT_INFO_CACHE_PREFIX', 'credit-info:'),
];
