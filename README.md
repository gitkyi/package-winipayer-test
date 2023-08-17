# This is my package package-winipayer-test

[![Latest Version on Packagist](https://img.shields.io/packagist/v/winipayer/package-winipayer-test.svg?style=flat-square)](https://packagist.org/packages/winipayer/package-winipayer-test)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/winipayer/package-winipayer-test/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/winipayer/package-winipayer-test/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/winipayer/package-winipayer-test/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/winipayer/package-winipayer-test/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/winipayer/package-winipayer-test.svg?style=flat-square)](https://packagist.org/packages/winipayer/package-winipayer-test)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/package-winipayer-test.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/package-winipayer-test)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

"require": {

    "php": "^7.4|^8.0",
    "laravel": "^8.75"

}

```bash
composer require winipayer/package-winipayer-test
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="package-winipayer-test-config"
```

This is the contents of the published config file:

```php
return [

    'env' => env('WINIPAYER_ENV', 'test'),

    'apply_key' => env('WINIPAYER_APPLY_KEY', ''),

    'token_key' => env('WINIPAYER_TOKEN_KEY', ''),

    'private_key' => env('WINIPAYER_PRIVATE_KEY', ''),

    'wpsecure' => env('WINIPAYER_WPSECURE', ''),

    'cancel_url' => env('WINIPAYER_CANCEL_URL', ''),

    'return_url' => env('WINIPAYER_RETURN_URL', ''),

    'callback_url' => env('WINIPAYER_CALLBACK_URL', '')
];
```

## Usage

```php

    //** Simple creation of an invoice **

    $winipayer = new Winipayer\Winipayer();

    echo $winipayer->createInvoice($amount, $description, $currency);

    //** Complex creation of an invoice **

    $winipayer = new Winipayer\Winipayer();

    echo $winipayer->setEndpoint('link_your_end_point')
    ->setItems(
        [
            [
                'name' => 'Pot de fleure',
                'quantity' => 2,
                'unit_price' => 3650,
                'total_price' => 7300
            ]
        ],
        ...
    )
    ->setWpsecure('true')// true or false
    ->setChannel(['mtn-cote-divoire','orange-cote-divoire']) // ['orange-cote-divoire','mtn-cote-divoire','wave-cote-divoire','stripe','cinetpay-ml','cinetpay-sn','cinetpay-tg','cinetpay-bf','cinetpay-bj','cinetpay-ne']
    ->setCustomerOwner(['uuid_or_id_owner'])
    ->setStore(
        [
            "name" => "Store",
            "description" => "description",
            "web_url" => "your_link_web_site",
            "logo_url" => "link_logo_web_store",
            "email" => "your_email",
            "phone" => "your_number_phone",
            "country" => "your_sigle_country",
            "city" => "your_city",
            "address" => "your_address",
            "ipn_url" => "your_link/ipn.php"
        ]
    )
    ->setCustomData(
        [
           'client_id' => 'client_id',
           'order_uuid' => Str::uuid()->__toString(),
        ]
    )
    ->setCancelUrl('https://tester.winipayer.com')
    ->setReturnUrl('https://tester.winipayer.com/success')
    ->setCallbackUrl('https://tester.winipayer.com/ipn')
    ->createInvoice($amount, $description, $currency);

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

-   [Kouakou Yao InnoCent](https://github.com/gitkyi)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
