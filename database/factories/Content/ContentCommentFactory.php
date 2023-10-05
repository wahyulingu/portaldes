<?php

namespace Database\Factories\Content;

use App\Enumerations\Moderation;
use App\Models\Content\ContentArticle;
use App\Models\Content\ContentComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content\ContentComment>
 */
class ContentCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => Str::ucfirst($this->faker->words(12, true)),
            'status' => Moderation::random(),
            'user_id' => User::factory(),
            'content_id' => ContentArticle::factory(),
            'content_type' => ContentArticle::class,
        ];
    }

    public function subcomment()
    {
        return $this->state(['parent_id' => ContentComment::factory()]);
    }

    public function status(Moderation $status)
    {
        return $this->state(['status' => $status->name]);
    }
}
