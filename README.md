## Laravel Theme Package

A theme system for Laravel 5.2 and above.

## Installation

Install the package through [Composer](http://getcomposer.org/). Edit your project's `composer.json` file by adding:

### Requirements

This package needs at least Laravel 5.2 and PHP 7.1.

### Install

First, you'll need to install the package via Composer:

```shell
$ composer require darthsoup/laravel-theme
```

### After Laravel 5.5

You do not need to do anything else here

### Before Laravel 5.5

Then, update `config/app.php` by adding an entry for the service provider.

```php
'providers' => [
    // ...
    DarthSoup\Theme\ThemeServiceProvider::class,
];
```

If you want to access the Theme via Facade than add a new line to the `aliases` array

```php
'aliases' => [
    // ...
    'Theme' => DarthSoup\Theme\Facades\Theme::class,
];
```

## Usage

WIP

## Contributions

Please use [Github](https://github.com/darthsoup/laravel-theme) for reporting bugs, and making comments or suggestions.
See [CONTRIBUTING.md](CONTRIBUTING.md) for how to contribute changes.