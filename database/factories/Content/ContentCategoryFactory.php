<?php

namespace Database\Factories\Content;

use App\Enumerations\Moderation;
use App\Models\Content\ContentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content\ContentArticle>
 */
class ContentCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::ucfirst($this->faker->words(3, true)),
            'description' => Str::ucfirst($this->faker->words(12, true)),
            'status' => Arr::random(Moderation::names()),
        ];
    }

    public function subcategory()
    {
        return $this->state(['parent_id' => ContentCategory::factory()]);
    }

    public function status(Moderation $status)
    {
        return $this->state(['status' => $status->name]);
    }
}
