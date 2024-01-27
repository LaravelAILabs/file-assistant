# AI File Assistant

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravelailabs/file-assistant.svg?style=flat-square)](https://packagist.org/packages/laravelailabs/file-assistant)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/laravelailabs/file-assistant/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/laravelailabs/file-assistant/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/laravelailabs/file-assistant/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/laravelailabs/file-assistant/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laravelailabs/file-assistant.svg?style=flat-square)](https://packagist.org/packages/laravelailabs/file-assistant)

Analyzez files based on AI and offers the possibility to query them.

## Support us

If this helped you, consider supporting my development over on [Patreon](https://patreon.com/AdrianTanase443).

## Installation

You can install the package via composer:

```bash
composer require laravelailabs/file-assistant
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="file-assistant-config"
```

## Usage

```php
$dialog = FileAssistant::addFile('PATH_TO_YOUR_FILE')->initialize();
echo $dialog->prompt('What is this document about?')
```

## Works with
- PDF
- Word
- TXT

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Adrian Tanase](https://github.com/adrianmtanase)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
