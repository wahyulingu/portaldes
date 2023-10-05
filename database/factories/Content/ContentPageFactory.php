<?php

namespace Database\Factories\Content;

use App\Enumerations\Moderation;
use App\Models\Content\ContentCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content\ContentPage>
 */
class ContentPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => Str::ucfirst($this->faker->words(12, true)),
            'body' => Str::ucfirst($this->faker->paragraphs(8, true)),
            'description' => Str::ucfirst($this->faker->words(12, true)),
            'status' => Moderation::random(),
            'user_id' => User::factory(),
        ];
    }

    public function categoryzed()
    {
        return $this->state(['category_id' => ContentCategory::factory()]);
    }

    public function status(Moderation $status)
    {
        return $this->state(['status' => $status->name]);
    }
}
