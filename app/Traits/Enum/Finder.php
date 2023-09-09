<?php

namespace App\Traits\Enum;

use Illuminate\Support\Collection;

trait Finder
{
    public static function findName(string $name): ?static
    {
        return static::collect()->where('name', $name)->first();
    }

    public static function findValue(string $value): ?static
    {
        return static::collect()->where('value', $value)->first();
    }

    public static function names(bool $asArray = false): Collection|array
    {
        $names = static::collect()->map(fn (self $enum) => $enum->name);

        if ($asArray) {
            return $names->toArray();
        }

        return $names;
    }

    public static function values(bool $asArray = false): Collection|array
    {
        $values = static::collect()->map(fn (self $enum) => $enum->value);

        if ($asArray) {
            return $values->toArray();
        }

        return $values;
    }

    public static function collect(): Collection
    {
        return collect(static::cases());
    }

    public static function random(): self
    {
        return static::collect()->random();
    }
}
