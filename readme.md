# Signature Field for Backpack 4

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

This package provides a ```signature``` field type for the [Backpack for Laravel](https://backpackforlaravel.com/) administration panel. The ```signature``` field allows admins to **let customers sign documents, in a prettier way**. It uses [Signature Pad Library](https://github.com/szimek/signature_pad).


## Screenshot

![https://user-images.githubusercontent.com/1032474/86575263-a77d9b00-bf7f-11ea-8116-536f9c81ec53.gif](https://user-images.githubusercontent.com/1032474/86575263-a77d9b00-bf7f-11ea-8116-536f9c81ec53.gif)

## Installation

Via Composer

``` bash
composer require imokhles/signature-field-for-backpack
```

## Usage

Inside your custom CrudController:

```php
$this->crud->addField([
    'name' => 'signature',
    'label' => 'Please sign here',
    'type' => 'signature',
    'view_namespace' => 'signature-field-for-backpack::fields',
]);
```

Notice the ```view_namespace``` attribute - make sure that is exactly as above, to tell Backpack to load the field from this _addon package_, instead of assuming it's inside the _Backpack\CRUD package_.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email [the author](composer.json) instead of using the issue tracker.

## Credits

- [iMokhles](https://github.com/imokhles) - created the signature field;
- [Cristian Tabacitu](https://github.com/tabacitu) - Backpack for Laravel;
- [Szymon Nowak](https://github.com/szimek) - Signature Pad;
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/imokhles/signature-field-for-backpack.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/imokhles/signature-field-for-backpack.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/imokhles/signature-field-for-backpack
[link-downloads]: https://packagist.org/packages/imokhles/signature-field-for-backpack
[link-author]: https://imokhles.com
[link-contributors]: ../../contributors
