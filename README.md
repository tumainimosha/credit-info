# Credit Info (Tanzania) - API Adapter

[![Build Status](https://travis-ci.org/princeton255/credit-info.svg?branch=master)](https://travis-ci.org/princeton255/credit-info)
[![styleci](https://styleci.io/repos/CHANGEME/shield)](https://styleci.io/repos/CHANGEME)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/princeton255/credit-info/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/princeton255/credit-info/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/CHANGEME/mini.png)](https://insight.sensiolabs.com/projects/CHANGEME)
[![Coverage Status](https://coveralls.io/repos/github/princeton255/credit-info/badge.svg?branch=master)](https://coveralls.io/github/princeton255/credit-info?branch=master)

[![Packagist](https://img.shields.io/packagist/v/princeton255/credit-info.svg)](https://packagist.org/packages/princeton255/credit-info)
[![Packagist](https://poser.pugx.org/princeton255/credit-info/d/total.svg)](https://packagist.org/packages/princeton255/credit-info)
[![Packagist](https://img.shields.io/packagist/l/princeton255/credit-info.svg)](https://packagist.org/packages/princeton255/credit-info)

A Laravel package for quick integration with [Credit Info Tanzania](https://creditinfo.co.tz) API.   

## Installation

First this package in repositories section of your `composer.json`

```json
...
    "repositories": [
        {
            "type": "vcs",
            "url": "git@bitbucket.org:princeton255/credit-info.git"
        }
    ],
...


```
Install via composer
```bash
composer require princeton255/credit-info:dev-master
```

### Publish Configuration File

Optional! Publish config file only if you wish to customize the default package config.

```bash
php artisan vendor:publish --provider="Princeton255\CreditInfo\ServiceProvider" --tag="config"
```

## Configuration

### Authentication
Configure your api username and password in `.env` file as follows

```.env
CREDIT_INFO_USERNAME=your_api_username
CREDIT_INFO_PASSWORD=your_api_password
```

Apart from authentication configurations, the following remaining configurations are optional.

### URL
The package config file comes with default API url pointing to production. To point to `test` environment set the CREDIT_INFO_WSDL key in your `.env` file to point to test url given. (See below)

```.env
CREDIT_INFO_WSDL=https://wstest.creditinfo.co.tz/WsReport/v5.39/service.svc?wsdl
```

Remember the WSDL url should end with a `?wsdl` suffix, don't forget to add this if you haven't already.


### Response Caching
The package by default caches API response from Credit Info to speed up subsequent requests for the same data. You can control this feature by setting the `CREDIT_INFO_CACHE_TTL` value in your `.env`. (See below)

```.env
CREDIT_INFO_CACHE_TTL=1440 # Default is 24 hours = 1440 minutes
```

Set the value to zero(0) to completely disable caching.

### WSDL Caching
Default behaviour of PHP Soap Client is to Cache WSDL files for improved performance. However, during development you may require for debugging reasons to disable WSDL caching of the soap client. To do so set the `CREDIT_INFO_CACHE_WSDL` key in your `.env` file to `false` (See below)

```.env
CREDIT_INFO_CACHE_WSDL=false
```

## Usage

### Get Vehicle Information

```php
use Princeton255\CreditInfo\Exceptions\DataNotFoundException;
use Princeton255\CreditInfo\Exceptions\Exception;
use Princeton255\CreditInfo\Facades\CreditInfo;

...
    $registration = 't100abc';
    
    try {
        $details = CreditInfo::getVehicleReport($registration);
    } 
    catch(DataNotFoundException $ex) {
        // Handle case if registration number not found
    }
    catch(Exception $e) {
        // Handle other API errors
    }
...

```

### TODO

- [x] Vehicle Report
- [ ] TIN Report
- [ ] Driving license Report
- [ ] National ID Report

## Security

If you discover any security related issues, please email [Me](mailto:princeton.mosha@gmail.com?subject=Credit+Info+API+Package+%7C+Security+Issue)
instead of using the issue tracker.

## Credits

- [Tumaini Mosha](https://github.com/princeton255)
- [All contributors](https://github.com/princeton255/credit-info/graphs/contributors)

This package is bootstrapped with the help of
[melihovv/laravel-package-generator](https://github.com/melihovv/laravel-package-generator).
