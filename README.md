# Make requests to the Shopify API from your Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/signifly/laravel-shopify.svg?style=flat-square)](https://packagist.org/packages/signifly/laravel-shopify)
[![Build Status](https://img.shields.io/travis/signifly/laravel-shopify/master.svg?style=flat-square)](https://travis-ci.org/signifly/laravel-shopify)
[![StyleCI](https://styleci.io/repos/119509746/shield?branch=master)](https://styleci.io/repos/119509746)
[![Quality Score](https://img.shields.io/scrutinizer/g/signifly/laravel-shopify.svg?style=flat-square)](https://scrutinizer-ci.com/g/signifly/laravel-shopify)
[![Total Downloads](https://img.shields.io/packagist/dt/signifly/laravel-shopify.svg?style=flat-square)](https://packagist.org/packages/signifly/laravel-shopify)

The `signifly/laravel-shopify` package allows you to easily make requests to the Shopify API.

## Installation

You can install the package via composer:

```bash
$ composer require signifly/laravel-shopify
```

The package will automatically register itself.


## Documentation

### Initializing the Client

You need to create a private app to receive the necessary credentials for interacting with Shopify.

```php
use Signifly\Shopify\Shopify;

$shopify = new Shopify(
    env('SHOPIFY_API_KEY'),
    env('SHOPIFY_API_PASSWORD'),
    env('SHOPIFY_DOMAIN'),
    env('SHOPIFY_API_VERSION')
);
```

**Resolve from the service container**

Using class:

```php
use Signifly\Shopify\Shopify;

$shopify = app(Shopify::class);
```

Using alias:

```php
$shopify = app('shopify');
```

**Resolve using the factory**

```php
$shopify = \Signifly\Shopify\Factory::fromConfig();
```

**Resolve using dependency injection**

You may also inject the Shopify class into a method of a Controller:

```php
use Illuminate\Http\Request;
use Signifly\Shopify\Shopify;

class ProductController
{
    public function index(Request $request, Shopify $shopify)
    {
        // do something here
    }
}
```

**By default it will look for credentials in your config, when resolving the client.*

### Making requests

Once a client has been initialized, you may make request to Shopify using the available methods. 

Let's take a look at a couple of examples:

```php
$shopify = \Signifly\Shopify\Factory::fromConfig();

// Get products
$products = $shopify->getProducts(); // returns a Collection of ProductResource

// Create a product
$product = $shopify->createProduct($data); // returns a ProductResource

// Get a specific product
$product = $shopify->getProduct($productId); // returns a ProductResource

// Update a product
$product = $shopify->updateProduct($productId, $data); // returns a ProductResource 

// Deleting a product
$shopify->deleteProduct($productId);
```

**Please refer to the [official documentation](https://shopify.dev/docs/admin-api/rest/reference) to check which attributes are required for each request.*



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
