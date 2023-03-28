# KRD RASTIN 2.0 SDK

This project provides a high level SDK for the KRD ([Krajowy Rejestr Długów](https://info.krd.pl/Programista/Wprowadzenie-do-KRD-API)) Rastin Protocl 2.0.

## Installation

Installation via composer. PHP 7.4+ required.

```sh
composer require goosfraba/krd-rastin
```

## Usage

### SDK Creation

Create the SDK instance

```php
use Goosfraba\KrdRastin\Soap\KrdRastinSoapApiFactory;
use Goosfraba\KrdRastin\Soap\Authorization;

$factory = KrdRastinSoapApiFactory::getInstance();

$apiDemo = $factory->createDemo(
    Authorization::loginAndPassword("demo-login", "demo-password")
); // creates API for DEMO WSDL

$apiDemo = $factory->createDemo(
    Authorization::loginAndPassword("your-prod-login", "your-prod-password")
); // creates API for PROD WSDL

```

### Verify the consumer's identity number / address (VerifyConsumerIdentityNumber method)

```php
use Goosfraba\KrdRastin\VerifyConsumerIdentityNumberRequest;
use Goosfraba\KrdRastin\VerifyConsumerIdentityNumberResponse;
use Goosfraba\KrdRastin\Exception\ValidationException;
use Goosfraba\KrdRastin\Exception\AuthenticationException;
use Goosfraba\KrdRastin\Exception\GenericException;

try {
    /** @var VerifyConsumerIdentityNumberResponse $result */
    $result = $api->verifyConsumerIdentityNumber(
        VerifyConsumerIdentityNumberRequest::create(
            "13300100037",
            "OKTAWIUSZ",
            "DE LORM",
            Address::create(
                "GÓRNICZA",
                "39",
                "20",
                "01203",
                "JÓZEFÓW"
            )
        )
    );
} catch (ValidationException $e) {
    // invalid PESEL (given number is not a valid PESEL number)
} catch (AuthenticationException $e) {
    // invalid login / password
} catch (GenericException $e) {
    // generic API exception, see \SoapFault for details
    $soapFault = $e->soapFault();
}

$result->isPeselValid(); // checks if PESEL is valid (false if given PESEL is not matching the given name)
$addressResult = $result->permanentAddressVerificationResult(); // Address validation result object
```

### Verify the consumer's ID Card (VerifyIDCard method)

```php

use Goosfraba\KrdRastin\VerifyIDCardRequest;
use Goosfraba\KrdRastin\VerifyIDCardResponse;

try {
    /** @var VerifyIDCardResponse $result */
    $result = $api->verifyIdCard(
        VerifyIDCardRequest::create(
            "51011500014",
            FullName::createWithLastName("ANDRZEJ", "PAWEŁ", "WALCZUK-KOWALSKA"),
            "VCX",
            "959351",
            date_create_immutable("2014-09-24"),
            date_create_immutable("2024-09-24")
        )
    );
} catch (AuthenticationException $e) {
    // invalid login / password
} catch (GenericException $e) {
    // generic API exception, see \SoapFault for details
    $soapFault = $e->soapFault();
}

/**
 * true if the ID Card number details (name, number, dates) 
 * matching the PESEL and the ID Card has not been invalidated
 */
$result->isValid();
```

### Check if the consumer's ID Card is canceled (VerifyIsIDCardCanceled method)

```php

use Goosfraba\KrdRastin\VerifyIsIDCardCanceledRequest;
use Goosfraba\KrdRastin\VerifyIsIDCardCanceledResponse;

try {
    /** @var VerifyIsIDCardCanceledResponse $result */
    $result = $api->verifyIsIdCardCanceled(
        VerifyIsIDCardCanceledRequest::create("VCX", "959351")
    );
} catch (AuthenticationException $e) {
    // invalid login / password
} catch (GenericException $e) {
    // generic API exception, see \SoapFault for details
    $soapFault = $e->soapFault();
}

/**
 * TRUE only if the ID Card number exists and it has been cancelled. 
 * Please not it will return FALSE for invalid ID Card so this should be used only along with VerifyIdCard method.
 */
$isCanceled = $result->isCanceled(); 
```

### Verify the consumer is alive (VerifyConsumerIsAlive method)

```php

use Goosfraba\KrdRastin\VerifyConsumerIsAliveRequest;
use Goosfraba\KrdRastin\VerifyConsumerIsAliveResponse;
use Goosfraba\KrdRastin\VerifyConsumerIsAliveStatus;
try {
    /** @var VerifyConsumerIsAliveResponse $result */
    $result = $api->verifyConsumerIsAlive(
        VerifyConsumerIsAliveRequest::create("14221400248", "DELFFINA", "TONDOSSSS")
    );
} catch (AuthenticationException $e) {
    // invalid login / password
} catch (GenericException $e) {
    // generic API exception, see \SoapFault for details
    $soapFault = $e->soapFault();
}

/**
 * Status is one of: 
 * VerifyConsumerIsAliveStatus::alive()
 * VerifyConsumerIsAliveStatus::notAlive()
 * VerifyConsumerIsAliveStatus::incorrectData()
 */
$status = $result->status();
```

## Contribution
Feel free to contribute into this repository with new features / bugfixes.
