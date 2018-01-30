# Make requests to the Shopify API from your Laravel app

The `signifly/laravel-shopify` package allows you to easily make requests to the Shopify API.

Below is a small example of how to use it. For now it only supports private app credentials.

```php
$shopify = new \Signifly\Shopify\Shopify('api-key', 'password', 'handle');

// Retrieve all products
$shopify->products()->all();

// Count all products
$shopify->products()->cancel();

// Update a product
$shopify->products()->update($id, $data);

// Delete a product
$shopify->products()->destroy($id);
```

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
- [Travis Elkins](https://github.com/telkins)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
