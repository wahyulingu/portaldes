<?php

namespace Tests\Feature\Action\Content;

use App\Actions\Content\Article\ArticleDeleteAction;
use App\Actions\Content\Article\ArticleStoreAction;
use App\Actions\Content\Article\ArticleUpdateAction;
use App\Actions\Content\Article\Index\ArticleIndexAction;
use App\Actions\Content\Article\Index\ArticleIndexByCategoryAction;
use App\Actions\Content\Article\Index\ArticleIndexByKeywordAction;
use App\Actions\Content\Article\Index\ArticleIndexByUserAction;
use App\Models\Content\ContentArticle;
use App\Models\Content\ContentCategory;
use App\Models\User;
use App\Repositories\FileRepository;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ArticleActionTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testCanStoreNewArticle(): void
    {
        /**
         * @var ArticleStoreAction
         */
        $action = app(ArticleStoreAction::class);

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $picture = UploadedFile::fake()->image('picture.jpg');

        $contentData = [
            'title' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
            'description' => $this->faker->paragraph,
        ];

        /**
         * @var ContentArticle
         */
        $article = $action

            ->prepare(User::factory()->create())
            ->execute([...$contentData, 'thumbnail' => $picture]);

        $this->assertDatabaseHas('content_articles', $contentData);

        $fakeStorage->assertExists($picture->hashName('content/thumbnails'));

        $this->assertEquals(
            expected: $picture->hashName('content/thumbnails'),
            actual: $article->thumbnail->picture->file->path
        );

        $fakeStorage->assertExists($article->thumbnail->picture->file->path);
    }

    public function testCanUpdateExistingArticle(): void
    {
        /**
         * @var ContentArticle
         */
        $article = ContentArticle::factory()->create();

        /**
         * @var ArticleUpdateAction
         */
        $action = app(ArticleUpdateAction::class);

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $picture = UploadedFile::fake()->image('picture.jpg');

        $contentData = [
            'title' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
            'category_id' => ContentCategory::factory()->create()->getKey(),
            'description' => $this->faker->paragraph,
        ];

        $action->prepare($article)->execute([...$contentData, 'thumbnail' => $picture]);

        $this->assertDatabaseHas('content_articles', [...$contentData, 'id' => $article->getKey()]);

        $this->assertEquals(
            expected: $picture->hashName('content/thumbnails'),
            actual: $article->thumbnail->picture->file->path
        );

        $fakeStorage->assertExists($article->thumbnail->picture->file->path);
    }

    public function testThumbnailAreAlsoDeletedIfDeletingArticle(): void
    {
        /**
         * @var ContentArticle
         */
        $article = ContentArticle::factory()->create();

        /**
         * @var ArticleDeleteAction
         */
        $deleteAction = app(ArticleDeleteAction::class);

        /**
         * @var ArticleUpdateAction
         */
        $updateAction = app(ArticleUpdateAction::class);

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $picture = UploadedFile::fake()->image('picture.jpg');
        $updateAction->prepare($article)->execute(['thumbnail' => $picture]);
        $fakeStorage->assertExists($article->thumbnail->picture->file->path);

        $deleteAction->prepare($article)->execute(['thumbnail' => $picture]);
        $fakeStorage->assertMissing($article->thumbnail->picture->file->path);
        $this->assertNull($article->fresh());
    }

    public function testArticleCanIndex()
    {
        $articles = ContentArticle::factory(5)->create();

        /**
         * @var ArticleIndexByUserAction
         */
        $action = app(ArticleIndexAction::class);

        $this->assertGreaterThan(0, $action->execute()->count());
    }

    public function testArticleCanIndexByUser()
    {
        /**
         * @var User
         */
        $user = User::factory()->create();
        $articles = ContentArticle::factory(5)->for($user, 'user')->create();

        /**
         * @var ArticleIndexByUserAction
         */
        $action = app(ArticleIndexByUserAction::class);

        $expectedArticleCount = $articles->count();
        $actualArticleCount = $action->prepare($user)->execute()->count();

        $this->assertEquals($expectedArticleCount, $actualArticleCount);
    }

    public function testArticleCanIndexByCategory()
    {
        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();
        $articles = ContentArticle::factory(5)->for($category, 'category')->create();

        /**
         * @var ArticleIndexByCategoryAction
         */
        $action = app(ArticleIndexByCategoryAction::class);

        $expectedArticleCount = $articles->count();
        $actualArticleCount = $action->prepare($category)->execute()->count();

        $this->assertEquals($expectedArticleCount, $actualArticleCount);
    }

    public function testArticleCanIndexByKeyword()
    {
        /**
         * @var ArticleIndexByKeywordAction
         */
        $action = app(ArticleIndexByKeywordAction::class);

        /**
         * @var ContentArticle
         */
        $article = ContentArticle::factory()->create();

        $this->assertGreaterThan(0, $action->execute(['keyword' => substr($article->body, 8, 24)])->count());
    }
}
