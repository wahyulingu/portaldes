<?php

namespace Database\Factories\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile\ProfileAuthor>
 */
class ProfileAuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'name' => $this->faker->name,
            'bio' => Str::ucfirst($this->faker->paragraph),
            'address' => $this->faker->address,
            'phone' => $this->faker->unique()->phoneNumber,
            'email' => $this->faker->unique()->email,
        ];
    }
}
