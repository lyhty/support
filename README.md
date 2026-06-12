[![Latest Stable Version](https://img.shields.io/packagist/v/lyhty/support?style=flat-square&label=&logo=packagist&logoColor=white)](https://packagist.org/packages/lyhty/support)
[![PHP](https://img.shields.io/packagist/php-v/lyhty/support?style=flat-square&label=&logo=php&logoColor=white)](https://packagist.org/packages/lyhty/support)
[![Laravel](https://img.shields.io/static/v1?label=&message=^12%20|%20^13&color=red&style=flat-square&logo=laravel&logoColor=white)](https://packagist.org/packages/lyhty/support)
[![Total Downloads](https://img.shields.io/packagist/dt/lyhty/support?style=flat-square)](https://packagist.org/packages/lyhty/support)
[![License](https://img.shields.io/packagist/l/lyhty/support?style=flat-square)](https://packagist.org/packages/lyhty/support)

<!-- CUTOFF -->

This package provides some additional, convenient helpers for you to use in your Laravel project.

## Installation

Install the package with Composer:

    composer require lyhty/support

## Features

### Helpers

- `class_has_attribute(object|string $class, string $attribute): bool`
  - Return boolean value whether the given class has given attribute.
- `class_uses_trait(object|string $class, string $trait, bool $recursive = true): bool`
  - Return boolean value whether the given class uses given trait.
- `array_depth(array $array): int`
  - Return integer describing the max depth of the given array.
- `class_implements_interface(object|string $class, string $interface): bool`
  - Return boolean value whether the given class implements given interface.
- `class_extends(object|string $class, string $parent): bool`
  - Return boolean value whether the given class extends given parent class.
- `set_type(mixed $value, string $type): mixed`
  - Alias for 'settype' which allows non-variables as arguments.
- `trim_spaces(string $string): string`
  - Trim spaces from string.
- `not_null(mixed $var): bool`
  - !is_null
- `get_bool(mixed $value): bool`
  - Get boolean value from given value. Accepts string true/false.
- `class_namespace(string $className): string`
  - Get namespace of given class.
- `___(array $keys, array $replace = [], array $numbers = [], string $locale = null, string $glue = ' '): string`
  - Translate given messages and glue them together.

### Discovery class

This is pretty much copied from `Illuminate\Foundation\Events\DiscoverEvents` from, just made more
generic.

**Examples**

```php
use Lyhty\Support\Discovery;

$all = Discovery::within('app\Models')->toArray();
// ["App\Models\User", "App\Models\BlogPost", "App\Models\Concerns\Taggable", "App\Models\Contracts\BlogWriter"]

$classes = Discovery::classesWithin('app\Models')->toArray();
// ["App\Models\User", "App\Models\BlogPost"]

$traits = Discovery::traitsWithin('app\Models')->toArray();
// ["App\Models\Concerns\Taggable"]

$interfaces = Discovery::interfacesWithin('app\Models')->toArray();
// ["App\Models\Contracts\BlogWriter"]

$usingClasses = Discovery::usesWithin('app\Models', 'App\Models\Concerns\Taggable')->toArray();
// ["App\Models\BlogPost"]

$implementingClasses = Discovery::implementsWithin('app\Models', 'App\Models\Contracts\BlogWriter')->toArray();
// ["App\Models\User"]

$extendingClasses = Discovery::extendsWithin('app\Models', 'Illuminate\Database\Eloquent\Model')->toArray();
// ["App\Models\User", "App\Models\BlogPost"]
```

## License

Lyhty Support is open-sourced software licensed under the [MIT license](LICENSE.md).
