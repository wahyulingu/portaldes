<?php

namespace Tests\Feature\Action\Content;

use App\Actions\Content\Category\CategoryDeleteAction;
use App\Actions\Content\Category\CategoryStoreAction;
use App\Actions\Content\Category\CategoryUpdateAction;
use App\Actions\Content\Category\Index\CategoryIndexAction;
use App\Actions\Content\Category\Index\CategoryIndexByKeywordAction;
use App\Models\Content\ContentCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryActionTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testCanStoreNewCategory(): void
    {
        /**
         * @var CategoryStoreAction
         */
        $action = app(CategoryStoreAction::class);

        $action->execute($contentData = [
            'name' => ucfirst($this->faker->words(8, true)),
            'description' => ucfirst($this->faker->words(8, true)),
        ]);

        $this->assertDatabaseHas('content_categories', $contentData);
    }

    public function testCanUpdateExistingCategory(): void
    {
        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();

        /**
         * @var CategoryUpdateAction
         */
        $action = app(CategoryUpdateAction::class);

        $contentData = [
            'name' => ucfirst($this->faker->words(8, true)),
            'description' => ucfirst($this->faker->words(8, true)),
            'parent_id' => ContentCategory::factory()->create()->getKey(),
        ];

        $action->prepare($category)->execute($contentData);

        $this->assertDatabaseHas('content_categories', [...$contentData, 'id' => $category->getKey()]);
    }

    public function testCanDeleteExistingCategory(): void
    {
        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();

        /**
         * @var CategoryDeleteAction
         */
        $deleteAction = app(CategoryDeleteAction::class);

        $deleteAction->prepare($category)->execute();

        $this->assertNull($category->fresh());
    }

    public function testCategoryCanIndex()
    {
        /**
         * @var CategoryIndexAction
         */
        $action = app(CategoryIndexAction::class);

        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();

        $this->assertGreaterThan(0, $action->execute()->count());
    }

    public function testCategoryCanIndexByKeyword()
    {
        /**
         * @var CategoryIndexByKeywordAction
         */
        $action = app(CategoryIndexByKeywordAction::class);

        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();

        $this->assertGreaterThan(0, $action->execute(['keyword' => substr($category->description, 8, 24)])->count());
    }
}
