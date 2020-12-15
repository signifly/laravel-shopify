# Make requests to the Shopify API from your Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/signifly/laravel-shopify.svg?style=flat-square)](https://packagist.org/packages/signifly/laravel-shopify)
[![Build Status](https://img.shields.io/travis/signifly/laravel-shopify/master.svg?style=flat-square)](https://travis-ci.org/signifly/laravel-shopify)
[![StyleCI](https://styleci.io/repos/119509746/shield?branch=master)](https://styleci.io/repos/119509746)
[![Quality Score](https://img.shields.io/scrutinizer/g/signifly/laravel-shopify.svg?style=flat-square)](https://scrutinizer-ci.com/g/signifly/laravel-shopify)
[![Total Downloads](https://img.shields.io/packagist/dt/signifly/laravel-shopify.svg?style=flat-square)](https://packagist.org/packages/signifly/laravel-shopify)

The `signifly/laravel-shopify` package allows you to easily make requests to the Shopify API.

Below is a small example of how to use it.

```php
use Signifly\Shopify\Shopify;

$shopify = app()->make(Shopify::class);

// Retrieve all products
$shopify->products()->all();

// Count all products
$shopify->products()->count();

// Update a product
$shopify->products()->update($id, $data);

// Delete a product
$shopify->products()->destroy($id);
```

Check the Shopify API reference to see what is available for each resource.

## Documentation
Until further documentation is provided, please have a look at the tests.

## Installation

You can install the package via composer:

```bash
$ composer require signifly/laravel-shopify
```

The package will automatically register itself.

## Testing
```bash
$ composer test
```

## Security

If you discover any security issues, please email dev@signifly.com instead of using the issue tracker.

## Credits

- [Morten Poul Jensen](https://github.com/pactode)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
