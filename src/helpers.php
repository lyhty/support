<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

if (! function_exists('class_uses_trait')) {
    /**
     * Return boolean value whether the given class uses given trait.
     *
     * @param  mixed  $class  An object (class instance) or a string (class name).
     * @param  string  $trait  Class name of the trait.
     * @param  bool  $recursive  Should trait's be found recursively.
     * @return bool
     */
    function class_uses_trait($class, $trait, bool $recursive = true): bool
    {
        $func = $recursive ? 'class_uses_recursive' : 'class_uses';

        return isset($func($class)[$trait]);
    }
}

if (! function_exists('array_depth')) {
    /**
     * Return integer describing the max depth of the given array.
     *
     * @param  array  $array
     * @return int
     */
    function array_depth(array $array)
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
     * @param  mixed  $class  An object (class instance) or a string (class name).
     * @param  string  $interface  Class name of the interface.
     * @return bool
     */
    function class_implements_interface($class, $interface): bool
    {
        return isset(class_implements($class)[$interface]);
    }
}

if (! function_exists('class_extends')) {
    /**
     * Return boolean value whether the given class extends given parent class.
     *
     * @param  mixed  $class  An object (class instance) or a string (class name).
     * @param  string  $interface  Class name of the parent class.
     * @return bool
     */
    function class_extends($class, $parent): bool
    {
        return isset(class_parents($class)[$parent]);
    }
}

if (! function_exists('set_type')) {
    /**
     * Alias for 'settype' which allows non-variables as arguments.
     *
     * @param  mixed  $value
     * @param  string  $type
     * @return void
     */
    function set_type($value, $type)
    {
        settype($value, $type);

        return $value;
    }
}

if (! function_exists('trim_spaces')) {
    /**
     * Trim spaces from string.
     *
     * @param  string  $string
     * @return string
     */
    function trim_spaces(string $string): string
    {
        return trim(preg_replace('/\s\s+/', ' ', $string));
    }
}

if (! function_exists('not_null')) {
    /**
     * !is_null.
     *
     * @param  mixed  $var
     * @return bool
     */
    function not_null($var): bool
    {
        return ! is_null($var);
    }
}

if (! function_exists('get_bool')) {
    /**
     * Get boolean value from given value. Accepts string true/false.
     *
     * @param  mixed  $value
     * @return bool
     */
    function get_bool($value): bool
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
     *
     * @param  string  $className
     * @return string
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
     * @return string
     */
    function ___(array $keys, array $replace = [], array $numbers = [], string $locale = null, string $glue = ' '): string
    {
        foreach ($keys as $index => &$key) {
            $key = isset($numbers[$index]) || Str::contains($key, '|')
                ? Lang::choice($key, Arr::get($numbers, $index, 1), [], $locale)
                : Lang::get($key, [], $locale);
        }

        return Lang::get(implode($glue, $keys), $replace);
    }
}
