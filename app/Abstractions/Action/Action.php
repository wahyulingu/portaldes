<?php

namespace App\Abstractions\Action;

use App\Contracts\Action\RuledActionContract;
use Illuminate\Support\Facades\Validator;

abstract class Action
{
    private array $skipedRules = [];

    private bool $skipRules = false;

    abstract protected function handler(array $validatedPayload = [], array $payload = []);

    final public function skipRules(array $rules): self
    {
        return tap($this, fn () => $this->skipedRules = array_merge($this->skipedRules, $rules));
    }

    final public function skipAllRules(): self
    {
        return tap($this, fn () => $this->skipRules = true);
    }

    final public function execute(array $payload = [])
    {
        $validatedPayload = $payload;

        if ($this instanceof RuledActionContract && true !== $this->skipRules) {
            $rules = $this->rules($payload);

            foreach ($this->skipedRules as $rule) {
                unset($rules[$rule]);
            }

            $validatedPayload = Validator::make($payload, $rules)->validate();
        }

        return $this->handler($validatedPayload, $payload);
    }

    final public static function handle(array $payload = [], callable $before = null)
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
