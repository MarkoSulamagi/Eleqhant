# Eleqhant

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Stable Release](https://img.shields.io/packagist/v/johnbillion/extended-cpts.svg)](https://packagist.org/packages/johnbillion/extended-cpts)

I created this small class to adjust eloquent a little bit. When extending the class with your model you will get following functionality:

- All database table names are in plural (`users`).
- All table ID keys prefix the table name in singular (users table has primary key user_id).
- If user is logged in  and edits database data, then Eleqhant automatically updates table created_by, updated_by and deleted_by columns (if they exist in table)

## Install

Via Composer

``` bash
$ composer require rentmarket/eleqhant
```

## Usage

Changes your models from extending Eloquent to Eleqhant and you are good to go

``` php
use Rentmarket\Eleqhant;

class User extends Eleqhant
{
    // ...
}
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

Tests have not been written yet

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [Marko Sulamägi][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/league/eleqhant.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/rentmarket/eleqhant
[link-author]: https://github.com/MarkoSulamagi
[link-contributors]: ../../contributors
