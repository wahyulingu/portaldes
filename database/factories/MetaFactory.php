<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meta>
 */
class MetaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(8, asText: true),
            'value' => [$this->faker->word => $this->faker->words(8)],
        ];
    }

    public function imune()
    {
        return $this->state(fn () => ['imune' => true]);
    }
}
