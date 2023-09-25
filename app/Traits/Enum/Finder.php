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

    public static function names(): Collection
    {
        return static::collect()->map(fn (self $enum) => $enum->name);
    }

    public static function values(): Collection
    {
        return static::collect()->map(fn (self $enum) => $enum->value);
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
