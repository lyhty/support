<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

if (! function_exists('class_has_attribute')) {
    /**
     * Return boolean value whether the given class has given attribute.
     *
     * @param  object|string  $class  An object (class instance) or a string (class name).
     * @param  string         $attribute  Name of the attribute class.
     */
    function class_has_attribute(object|string $class, string $attribute): bool
    {
        return count((new ReflectionClass($class))->getAttributes($attribute)) > 0;
    }
}

if (! function_exists('class_uses_trait')) {
    /**
     * Return boolean value whether the given class uses given trait.
     *
     * @param  object|string  $class  An object (class instance) or a string (class name).
     * @param  string         $trait  Class name of the trait.
     * @param  bool           $recursive  Should trait's be found recursively.
     */
    function class_uses_trait(object|string $class, string $trait, bool $recursive = true): bool
    {
        return isset((($recursive ? class_uses_recursive(...) : class_uses(...))($class) ?: [])[$trait]);
    }
}

if (! function_exists('array_depth')) {
    /**
     * Return integer describing the max depth of the given array.
     *
     * @return int
     */
    function array_depth(array $array): int
    {
        $depth = 0;
        $iteIte = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));

        foreach ($iteIte as $ite) {
            $d = $iteIte->getDepth();
            $depth = $d > $depth ? $d : $depth;
        }

        return $depth;
    }
}

if (! function_exists('class_implements_interface')) {
    /**
     * Return boolean value whether the given class implements given interface.
     *
     * @template T
     *
     * @param  object|string    $class      An object (class instance) or a string (class name).
     * @param  class-string<T>  $interface  Class name of the interface.
     *
     * @phpstan-assert-if-true ($class is object ? T : class-string<T>) $class
     */
    function class_implements_interface(object|string $class, string $interface): bool
    {
        return isset((class_implements($class) ?: [])[$interface]);
    }
}

if (! function_exists('class_extends')) {
    /**
     * Return boolean value whether the given class extends given parent class.
     *
     * @template T
     *
     * @param  object|string    $class   An object (class instance) or a string (class name).
     * @param  class-string<T>  $parent  Class name of the parent class.
     *
     * @phpstan-assert-if-true ($class is object ? T : class-string<T>) $class
     */
    function class_extends(object|string $class, string $parent): bool
    {
        return isset((class_parents($class) ?: [])[$parent]);
    }
}

if (! function_exists('set_type')) {
    /**
     * Alias for 'settype' which allows non-variables as arguments.
     */
    function set_type(mixed $value, string $type): mixed
    {
        settype($value, $type);

        return $value;
    }
}

if (! function_exists('trim_spaces')) {
    /**
     * Trim spaces from string.
     */
    function trim_spaces(string $string): string
    {
        return trim(preg_replace('/\s\s+/', ' ', $string));
    }
}

if (! function_exists('not_null')) {
    /**
     * !is_null
     *
     * @template TInput
     *
     * @param TInput|null $var
     *
     * @phpstan-assert-if-true TInput $var
     * @psalm-assert-if-true TInput $var
     */
    function not_null(mixed $var)
    {
        return ! is_null($var);
    }
}

if (! function_exists('get_bool')) {
    /**
     * Get boolean value from given value. Accepts string true/false.
     */
    function get_bool(mixed $value): bool
    {
        switch ($value) {
            case 'true': return true;
            case 'false': return false;
            default: return set_type($value, 'boolean');
        }
    }
}

if (! function_exists('class_namespace')) {
    /**
     * Get namespace of given class.
     */
    function class_namespace(string $className): string
    {
        return (string) Str::of($className)->before('\\'.class_basename($className));
    }
}

if (! function_exists('___')) {
    /**
     * Translate given messages and glue them together.
     *
     * @param  array  $keys  Translation keys / strings that will be translated.
     * @param  array  $replace  Wildcards to be replaced.
     *                          Example: `['name' => 'value']` would replace `:name` with `value` in given keys.
     * @param  array  $numbers  Array of numbers that dictate whether choice
     *                          translation method will be utilized for matching index in `$keys` array.
     * @param  string|null  $locale  Locale for given translation keys.
     * @param  string  $glue  What the translated keys should be glued together with.
     */
    function ___(array $keys, array $replace = [], array $numbers = [], ?string $locale = null, string $glue = ' '): string
    {
        foreach ($keys as $index => &$key) {
            $key = isset($numbers[$index]) || Str::contains($key, '|')
                ? Lang::choice($key, Arr::get($numbers, $index, 1), [], $locale)
                : Lang::get($key, [], $locale);
        }

        return Lang::get(implode($glue, $keys), $replace);
    }
}
