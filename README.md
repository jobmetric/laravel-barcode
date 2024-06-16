[contributors-shield]: https://img.shields.io/github/contributors/jobmetric/laravel-barcode.svg?style=for-the-badge
[contributors-url]: https://github.com/jobmetric/laravel-barcode/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/jobmetric/laravel-barcode.svg?style=for-the-badge&label=Fork
[forks-url]: https://github.com/jobmetric/laravel-barcode/network/members
[stars-shield]: https://img.shields.io/github/stars/jobmetric/laravel-barcode.svg?style=for-the-badge
[stars-url]: https://github.com/jobmetric/laravel-barcode/stargazers
[license-shield]: https://img.shields.io/github/license/jobmetric/laravel-barcode.svg?style=for-the-badge
[license-url]: https://github.com/jobmetric/laravel-barcode/blob/master/LICENCE.md
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-blue.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/majidmohammadian

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]

# Barcode for laravel

This is a barcode management package for Laravel that you can use in your projects.

## Install via composer

Run the following command to pull in the latest version:

```bash
composer require jobmetric/laravel-barcode
```

## Documentation

Undergoing continuous enhancements, this package evolves each day, integrating an array of diverse features. It stands as an indispensable asset for enthusiasts of Laravel, offering a seamless way to harmonize their projects with barcode database models.

In this package, you can employ it seamlessly with any model requiring database barcode.

Now, let's delve into the core functionality.

>#### Before doing anything, you must migrate after installing the package by composer.

```bash
php artisan migrate
```

Meet the `HasBarcode` class, meticulously designed for integration into your model. This class automates essential tasks, ensuring a streamlined process for:

In the first step, you need to connect this class to your main model.

```php
use JobMetric\Barcode\HasBarcode;

class Product extends Model
{
    use HasBarcode;
}
```

## How is it used?

### Storing a barcode

You can now use the `HasBarcode` class to store barcodes for your model. The following example shows how to create a new product by saving a barcode:

```php
$product = new Product();
$product->name = 'Product 1';
$product->save();

$product->storeBarcode('ean13', '1234567890123');
```

In this example, we created a new product and saved it to the database. Then, we stored a barcode for the product using the `storeBarcode` method. The first parameter is the barcode type, and the second parameter is the barcode value.

### Retrieving a barcode

You can retrieve a barcode for a model using the `getBarcode` method. The following example shows how to retrieve a barcode for a product:

```php
$product = Product::find(1);
$barcode = $product->getBarcode('ean13');
```

In this example, we retrieved a product from the database and then retrieved the barcode for the product using the `getBarcode` method. The parameter is the barcode type.

### Deleting a barcode

You can delete a barcode for a model using the `deleteBarcode` method. The following example shows how to delete a barcode for a product:

```php
$product = Product::find(1);
$product->forgetBarcode('ean13');
```

In this example, we retrieved a product from the database and then deleted the barcode for the product using the `forgetBarcode` method. The parameter is the barcode type.

### Delete all barcodes

You can delete all barcodes for a model using the `deleteAllBarcodes` method. The following example shows how to delete all barcodes for a product:

```php
$product = Product::find(1);
$product->forgetAllBarcodes();
```

In this example, we retrieved a product from the database and then deleted all barcodes for the product using the `forgetAllBarcodes` method.

### Checking if a barcode exists

You can check if a barcode exists for a model using the `hasBarcode` method. The following example shows how to check if a barcode exists for a product:

```php
$product = Product::find(1);
$exists = $product->hasBarcode('ean13');
```

In this example, we retrieved a product from the database and then checked if a barcode exists for the product using the `hasBarcode` method. The parameter is the barcode type.

### Updating a barcode

You can update a barcode for a model using the `storeBarcode` method. The following example shows how to update a barcode for a product:

```php
$product = Product::find(1);
$product->storeBarcode('ean13', '1234567890124');
```

In this example, we retrieved a product from the database and then updated the barcode for the product using the `storeBarcode` method. The first parameter is the barcode type, and the second parameter is the new barcode value.

### Add barcodeable attribute in Resource

In the barcode resource, there is a field called `bacodeable` that can display your model, but it must be set as follows.

First, you create a listener for the model you want to display in the barcode resource.

```php
php artisan make:listener AddProductResourceToBarcodableResourceListener
```

Then, you add the following code to the listener.

```php
use JobMetric\Barcode\Events\BarcodeableResourceEvent;

class AddProductResourceToBarcodableResourceListener
{
    public function handle(BarcodeableResourceEvent $event)
    {
        $barcodeable = $event->barcodeable;

        if ($barcodeable instanceof \App\Models\Product) {
            $event->resource = new \App\Http\Resources\ProductResource($barcodeable);
        }
    }
}
```

Finally, you add the listener to the `EventServiceProvider` class.

```php
protected $listen = [
    \JobMetric\Barcode\Events\BarcodeableResourceEvent::class => [
        \App\Listeners\AddProductResourceToBarcodableResourceListener::class,
    ],
];
```

The work is done, now when the BarcodeResource is called and if the ProductResource should be returned, the details of that resource will be displayed in the barcodeable attribute.

## Barcode Types

This package supports the following barcode types:

- `code128`
- `code39`
- `code93`
- `codabar`
- `ean13`
- `ean8`
- `upc`
- `upcext`
- `isbn`
- `datamatrix`
- `pdf417`
- `qrcode`
- `itf14`
- `interleaved2of5`
- `postnet`
- `msi`
- `pharmacode`
- `maxicode`
- `aztec`
- `code11`
- `code128a`
- `code128b`
- `code128c`
- `code39extended`
- `code39mod43`
- `code93extended`
- `gs1_128`
- `gs1_128composite`
- `gs1_cc`
- `gs1datamatrix`
- `gs1datamatrixrectangular`
- `gs1qrcode`

## Events

This package contains several events for which you can write a listener as follows

| Event                | Description                                        |
|----------------------|----------------------------------------------------|
| `BarcodeStoredEvent` | This event is called after storing the barcode.    |
| `BarcodeUpdateEvent` | This event is called after updating the barcode.   |
| `BarcodeForgetEvent` | This event is called after forgetting the barcode. |


## Contributing

Thank you for considering contributing to the Laravel Barcode! The contribution guide can be found in the [CONTRIBUTING.md](https://github.com/jobmetric/laravel-barcode/blob/master/CONTRIBUTING.md).

## License

The MIT License (MIT). Please see [License File](https://github.com/jobmetric/laravel-barcode/blob/master/LICENCE.md) for more information.
