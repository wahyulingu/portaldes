<?php

namespace App\Abstractions\Action;

use App\Contracts\Action\RuledActionContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

abstract class Action
{
    private array $skipedRules = [];

    private bool $skipRules = false;

    abstract protected function handler(Collection $validatedPayload, Collection $payload);

    final public function skipRules(array $rules): self
    {
        return tap($this, fn () => $this->skipedRules = array_merge($this->skipedRules, $rules));
    }

    final public function skipAllRules(): self
    {
        return tap($this, fn () => $this->skipRules = true);
    }

    final public function execute(Collection|array $payload = [])
    {
        $payload = collect($payload);

        if ($this instanceof RuledActionContract && true !== $this->skipRules) {
            $rules = collect($this->rules($payload));

            collect($this->skipedRules)->each(fn (string $rule) => $rules->pull($rule));

            $validatedPayload = Validator::make($payload->toArray(), $rules->toArray())->validate();
        }

        return $this->handler(collect(@$validatedPayload ?: $payload), $payload);
    }

    final public static function handle(Collection|array $payload = [], callable $before = null)
    {
        /**
         * @var self
         */
        $action = app(static::class);

        if (isset($before)) {
            $before($action);
        }

        return $action->execute($payload);
    }
}
