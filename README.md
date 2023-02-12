# Laravel SDK for Providus Bank APIs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stephenjude/providus-sdk.svg?style=flat-square)](https://packagist.org/packages/stephenjude/providus-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/stephenjude/providus-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/stephenjude/providus-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/stephenjude/providus-sdk/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/stephenjude/providus-sdk/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/stephenjude/providus-sdk.svg?style=flat-square)](https://packagist.org/packages/stephenjude/providus-sdk)

Laravel SDK for Providus Bank collection APIs

## Installation

You can install the package via composer:

```bash
composer require stephenjude/providus-sdk
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="providus-sdk-config"
```

This is the contents of the published config file:

```php
return [
    'id' => env('PROVIDUS_ID'),

    'secret' => env('PROVIDUS_SECRET'),

    'base_url' => env('PROVIDUS_BASE_URL', 'http://154.113.16.142:8088/AppDevAPI/api/'),

    /**
     * Set SDK to demo mode. This mode makes use of the demo signature provided by Providus bank.
     */
    'demo_mode' => env('PROVIDUS_DEMO', false),

    /**
     * Auth signature used for demo requests
     */
    'demo_signature' => 'BE09BEE831CF262226B426E39BD1092AF84DC63076D4174FAC78A2261F9A3D6E59744983B8326B69CDF2963FE314DFC89635CFA37A40596508DD6EAAB09402C7',

    'webhook' => [
        /**
         * This secret is used to verify that the payload has not been tampered with.
         */
        'signing_secret' => env('PROVIDUS_SECRET'),

        /**
         * The name of the header containing the signature.
         */
        'signature_header_name' => 'X-Auth-Signature',

        /**
         * This class will verify that the content of the signature header is valid.
         * It should implement \Providus\Providus\SignatureValidator\SignatureValidator
         */
        'signature_validator' => \Providus\Providus\SignatureValidator\DefaultSignatureValidator::class,

        /**
         * The classname of the controller to be used to process the webhook.
         * This should be set to a class that extends \Providus\Providus\Http\Controllers\WebhookController::class
         */
        'controller' => \Providus\Providus\Http\Controllers\WebhookController::class,

        /**
         * The route path that maps the webhook request to the webhook controller.
         */
        'path' => '/internals/webhook/providus/events',
    ],
];
```

## Usage
Initiailize the Providus API
```php
$bank = new \Providus\Providus\Providus();

$bank->verifyTransactionBySessionId(SETTLEMENT_ID);

//Or use Facade
use \Providus\Providus\Facades\Providus;

Providus::verifyTransactionBySessionId(SETTLEMENT_ID);
```
### Creating dynamic account number:
```php
$accountDetails = $bank->createDynamicAccountNumber('customer_name');
$accountDetails->accountName;
$accountDetails->accountNumber;
```
### Creating reserved account number:
```php
$accountDetails =  $bank->createReservedAccountNumber('customer_name', 'customer_bvn');
$accountDetails->accountName;
$accountDetails->accountNumber;
$accountDetails->bvn;
```
### Updating account name:
```php
$accountDetails = $bank->updateAccountName('customer_updated_name', 'customer_account_number');
$accountDetails->accountName;
$accountDetails->accountNumber;
```

### Blacklisting account number:
```php
$bank->blacklistAccountNumber('customer_account_number');
```

### Verifying transaction using session or settlement ID:

```php
$transaction = $bank->verifyTransactionBySessionId('session_id');

$transaction =  $bank->verifyTransactionBySettlementId('settlement_id');

$transaction->sessionId;
$transaction->settlementId;
$transaction->accountNumber;
$transaction->currency;
$transaction->transactionAmount;
$transaction->transactionReference;
$transaction->transactionDate;
$transaction->feeAmount;
$transaction->settledAmount;
$transaction->sourceAccountNumber;
$transaction->sourceAccountNumber;
$transaction->sourceBankName;
$transaction->remarks;
$transaction->channelId;
```

### Webbhook Controller
You have to create a controller class that extends the base webhook controller that comes with this package. Update the providus config file to use your own defined controller.

```php
   /**
     * The classname of the controller to be used to process the webhook.
     * This should be set to a class that extends \Providus\Providus\Http\Controllers\WebhookController::class
     */
    'controller' => App\Http\Controllers\ProvidusWebhookController::class,
```
Update your controller like this to return the valid responses to providus for successful and duplicate responses. This package handles rejected response for you.
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Providus\Providus\Http\Controllers\WebhookController;

class ProvidusWebhookController extends WebhookController
{
    public function handle(Request $request)
    {
        parent::handle($request);

        if ($this->sessionHasDuplicate($request->input('sessionId'))) {
            return $this->duplicateResponse($request);
        }

       // Webhook request is valid, so you can do your thing here.

        return $this->successfulResponse($request);
    }
    
    public function sessionHasDuplicate(string $sessionId){
    
        // Check if session ID has duplicate. A duplicate sessions is for transaction you have already processed previously.
        
    }
}

```



## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Stephen Jude](https://github.com/stephenjude)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
