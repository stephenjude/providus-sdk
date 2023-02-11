# Laravel SDK for Providus Bank APIs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stephenjude/providus-sdk.svg?style=flat-square)](https://packagist.org/packages/stephenjude/providus-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/stephenjude/providus-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/stephenjude/providus-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/stephenjude/providus-sdk/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/stephenjude/providus-sdk/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/stephenjude/providus-sdk.svg?style=flat-square)](https://packagist.org/packages/stephenjude/providus-sdk)

This package is used for consuming providus bank apis.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/providus-sdk.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/providus-sdk)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

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
