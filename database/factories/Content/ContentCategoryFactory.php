<?php

namespace Database\Factories\Content;

use App\Enumerations\Content\CategoryStatus;
use App\Models\Content\ContentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
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
            'status' => CategoryStatus::random(),
        ];
    }

    public function subcategory()
    {
        return $this->state(['parent_id' => ContentCategory::factory()]);
    }

    public function status(CategoryStatus $status)
    {
        return $this->state(['status' => $status->name]);
    }
}
