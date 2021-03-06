<p align="center">
<h1>Credit Info (TZ) API Wrapper for Laravel</h1>


[![Latest Stable Version](https://poser.pugx.org/tumainimosha/credit-info/v/stable)](https://packagist.org/packages/tumainimosha/credit-info)
[![License](https://poser.pugx.org/tumainimosha/credit-info/license)](https://packagist.org/packages/tumainimosha/credit-info)
[![Total Downloads](https://poser.pugx.org/tumainimosha/credit-info/downloads)](https://packagist.org/packages/tumainimosha/credit-info)
</p>

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

1. [Vehicle Report](#vehicle-report)
2. [Driving License Report](#driving-license-report)
3. [National Id Report](#national-id-report)
4. [Exception Handling](#exception-handling)

### Vehicle Report

Method `getVehicleReport()` queries vehicle information by Vehicle Registration ID

```php 
$creditInfoService = new \CreditInfo\CreditInfo();
$details = $creditInfoService->getVehicleReport($registration_number);
```

### Driving License Report

Method `getDrivingLicenseReport()` queries drivers license information by Driving License Number

```php 
$creditInfoService = new \CreditInfo\CreditInfo();
$details = $creditInfoService->getDrivingLicenseReport($driving_license_no);
```


### National Id Report

Method `getNationalIdReport()` queries an individual information by National Id Number

```php 
$creditInfoService = new \CreditInfo\CreditInfo();
$details = $creditInfoService->getNationalIdReport($national_id);
```

### Exception Handling

The above methods throws the following exceptions

| Exception                                               | Condition                                                                                                                                     |
|---------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------|
| `CreditInfo\Exceptions\Exception`                       | This is the package's base exception. All exceptions from this library inherit from it. <br><br> *** This should be caught last as a catch-all statement. |
| `CreditInfo\Exceptions\InvalidReferenceNumberException` | Thrown if supplied reference number fails validation requirements.                                                                            |
| `CreditInfo\Exceptions\DataNotFoundException`           | Thrown if no data found for given reference number                                                                                           |
| `CreditInfo\Exceptions\TimeoutException`                | Thrown if request timeouts                                                                                                                   |

<br>
See usage below with exception catching

```php
use CreditInfo\Exceptions\DataNotFoundException;
use CreditInfo\Exceptions\Exception;
use CreditInfo\Exceptions\InvalidReferenceNumberException;
use CreditInfo\Exceptions\TimeoutException;
use CreditInfo\CreditInfo;

...

public function testVehicleInfo() {

    $registration = 't100abc';
    
    $creditInfoService = new CreditInfo();
    try {
        $details = $creditInfoService->getVehicleReport($registration);
    } 
    catch(InvalidReferenceNumberException $ex) {
        // Handle case invalid reference number case
        throw($ex);
    }
    catch(TimeoutException $ex) {
        // Handle case if request timeout
        throw($ex);
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
