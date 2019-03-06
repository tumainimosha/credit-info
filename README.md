# Credit Info (TZ) API


[![Latest Stable Version](https://poser.pugx.org/tumainimosha/credit-info/v/stable)](https://packagist.org/packages/tumainimosha/credit-info)
[![License](https://poser.pugx.org/princeton255/tumainimosha/credit-info/license)](https://packagist.org/packages/tumainimosha/credit-info)
[![Total Downloads](https://poser.pugx.org/tumainimosha/credit-info/downloads)](https://packagist.org/packages/tumainimosha/credit-info)


The Unofficial [Credit Info Tanzania](https://creditinfo.co.tz) API wrapper for Laravel.   

* [CreditInfo Tanzania website](https://tz.creditinfo.com/)
* [WSDL](https://ws.creditinfo.co.tz/WsReport/v5.39/service.svc?singleWsdl) (requires _Basic Auth_ authentication)

## Installation

Install via composer

```bash
composer require tumainimosha/credit-info
```


### Publish Configuration File

Optional! Publish config file only if you wish to customize the default package config.

```bash
php artisan vendor:publish --provider="CreditInfo\ServiceProvider" --tag="config"
```

## Configuration

### Authentication
Configure your api username and password in `.env` file as follows

```dotenv
CREDIT_INFO_USERNAME=your_api_username
CREDIT_INFO_PASSWORD=your_api_password
```

Apart from authentication configurations, the following remaining configurations are optional.

For basic usage jump straight to [Usage Section](#usage)

### URL
The package config file comes with default API url pointing to `production`. 

```dotenv
CREDIT_INFO_WSDL=https://ws.creditinfo.co.tz/WsReport/v5.39/service.svc?wsdl
```

To point to `test` environment set the CREDIT_INFO_WSDL key in your `.env` file to point to test url given. (See below)

```dotenv
CREDIT_INFO_WSDL=https://wstest.creditinfo.co.tz/WsReport/v5.39/service.svc?wsdl
```

Remember 
* The WSDL url should end with a `?wsdl` suffix, don't forget to add this if you haven't already.
* You need to first configure correct [Authentication](#authentication) details above for your respective environment, as the WSDL url is secured with Basic Auth.


### Response Caching

The package by default caches API response from Credit Info to speed up subsequent requests for the same data. 

You can control this feature by setting the `CREDIT_INFO_CACHE_TTL` value in minutes in your `.env`. (See below)

By default data is cached for 24 hours = 1440 minutes

```dotenv
CREDIT_INFO_CACHE_TTL=1440
```


Set the value to zero(0) to completely disable caching.


### WSDL Caching

Default behaviour of PHP Soap Client is to Cache WSDL files for improved performance. 

However, during development you may require for debugging reasons to disable WSDL caching of the soap client. 

To do so set the `CREDIT_INFO_CACHE_WSDL` key in your `.env` file to `false` (See below)

**Caution:** Disabling WSDL caching will significantly slow down performance. Please remember to always revert this option to `true` after you are done debugging.

```dotenv
CREDIT_INFO_CACHE_WSDL=false
```


## Usage

### 1. Get Vehicle Information

Method `getVehicleReport()` queries vehicle information database by Vehicle Registration ID

```php 
$creditInfoService = new \CreditInfo\CreditInfo();
$details = $creditInfoService->getVehicleReport($registration_number);
```

This method throws the following exceptions
1. `CreditInfo\Exceptions\DataNotFoundException` if no data on for given reference number
2. `CreditInfo\Exceptions\TimeoutException` if request times out
3. `CreditInfo\Exceptions\Exception` generic exception for all other errors

See usage below with exception catching

```php
use CreditInfo\Exceptions\DataNotFoundException;
use CreditInfo\Exceptions\Exception;
use CreditInfo\CreditInfo;

...

public function test() {
    $registration = 't100abc';
    
    $creditInfoService = new CreditInfo();
    try {
        $details = $creditInfoService->getVehicleReport($registration);
    } 
    catch(DataNotFoundException $ex) {
        // Handle case if registration number not found
        throw($ex);
    }
    catch(Exception $e) {
        // Handle other API errors
        throw($e);
    }
    
    dd($details);
}
...

```


### TODO

- [x] Vehicle Report
- [x] Driving license Report
- [x] National ID Report
- [ ] TIN Report


## Security

If you discover any security related issues, please email [Me](mailto:princeton.mosha@gmail.com?subject=Credit+Info+API+Package+Security+Issue)
instead of using the issue tracker.


## Credits

- [Tumaini Mosha](https://github.com/princeton255)
- [All contributors](https://github.com/princeton255/credit-info/graphs/contributors)


This package is bootstrapped with the help of
[melihovv/laravel-package-generator](https://github.com/melihovv/laravel-package-generator).
