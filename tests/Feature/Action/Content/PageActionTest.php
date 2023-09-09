<?php

namespace Tests\Feature\Action\Content;

use App\Actions\Content\Page\Index\PageIndexAction;
use App\Actions\Content\Page\Index\PageIndexByCategoryAction;
use App\Actions\Content\Page\Index\PageIndexByKeywordAction;
use App\Actions\Content\Page\Index\PageIndexByUserAction;
use App\Actions\Content\Page\PageDeleteAction;
use App\Actions\Content\Page\PageStoreAction;
use App\Actions\Content\Page\PageUpdateAction;
use App\Models\Content\ContentCategory;
use App\Models\Content\ContentPage;
use App\Models\User;
use App\Repositories\FileRepository;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PageActionTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testCanStoreNewPage(): void
    {
        /**
         * @var PageStoreAction
         */
        $action = app(PageStoreAction::class);

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $picture = UploadedFile::fake()->image('picture.jpg');

        $contentData = [
            'title' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
            'description' => $this->faker->paragraph,
        ];

        /**
         * @var ContentPage
         */
        $page = $action

            ->prepare(User::factory()->create())
            ->execute([...$contentData, 'thumbnail' => $picture]);

        $this->assertDatabaseHas('content_pages', $contentData);

        $fakeStorage->assertExists($picture->hashName('content/thumbnails'));

        $this->assertEquals(
            expected: $picture->hashName('content/thumbnails'),
            actual: $page->thumbnail->picture->file->path
        );

        $fakeStorage->assertExists($page->thumbnail->picture->file->path);
    }

    public function testCanUpdateExistingPage(): void
    {
        /**
         * @var ContentPage
         */
        $page = ContentPage::factory()->create();

        /**
         * @var PageUpdateAction
         */
        $action = app(PageUpdateAction::class);

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $picture = UploadedFile::fake()->image('picture.jpg');

        $contentData = [
            'title' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
            'category_id' => ContentCategory::factory()->create()->getKey(),
            'description' => $this->faker->paragraph,
        ];

        $action->prepare($page)->execute([...$contentData, 'thumbnail' => $picture]);

        $this->assertDatabaseHas('content_pages', [...$contentData, 'id' => $page->getKey()]);

        $this->assertEquals(
            expected: $picture->hashName('content/thumbnails'),
            actual: $page->thumbnail->picture->file->path
        );

        $fakeStorage->assertExists($page->thumbnail->picture->file->path);
    }

    public function testThumbnailAreAlsoDeletedIfDeletingPage(): void
    {
        /**
         * @var ContentPage
         */
        $page = ContentPage::factory()->create();

        /**
         * @var PageDeleteAction
         */
        $deleteAction = app(PageDeleteAction::class);

        /**
         * @var PageUpdateAction
         */
        $updateAction = app(PageUpdateAction::class);

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $picture = UploadedFile::fake()->image('picture.jpg');
        $updateAction->prepare($page)->execute(['thumbnail' => $picture]);
        $fakeStorage->assertExists($page->thumbnail->picture->file->path);

        $deleteAction->prepare($page)->execute(['thumbnail' => $picture]);
        $fakeStorage->assertMissing($page->thumbnail->picture->file->path);
        $this->assertNull($page->fresh());
    }

    public function testPageCanIndex()
    {
        $pages = ContentPage::factory(5)->create();

        /**
         * @var PageIndexByUserAction
         */
        $action = app(PageIndexAction::class);

        $this->assertGreaterThan(0, $action->execute()->count());
    }

    public function testPageCanIndexByUser()
    {
        /**
         * @var User
         */
        $user = User::factory()->create();
        $pages = ContentPage::factory(5)->for($user, 'user')->create();

        /**
         * @var PageIndexByUserAction
         */
        $action = app(PageIndexByUserAction::class);

        $expectedPageCount = $pages->count();
        $actualPageCount = $action->prepare($user)->execute()->count();

        $this->assertEquals($expectedPageCount, $actualPageCount);
    }

    public function testPageCanIndexByCategory()
    {
        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();
        $pages = ContentPage::factory(5)->for($category, 'category')->create();

        /**
         * @var PageIndexByCategoryAction
         */
        $action = app(PageIndexByCategoryAction::class);

        $expectedPageCount = $pages->count();
        $actualPageCount = $action->prepare($category)->execute()->count();

        $this->assertEquals($expectedPageCount, $actualPageCount);
    }

    public function testPageCanIndexByKeyword()
    {
        /**
         * @var PageIndexByKeywordAction
         */
        $action = app(PageIndexByKeywordAction::class);

        /**
         * @var ContentPage
         */
        $page = ContentPage::factory()->create();

        $this->assertGreaterThan(0, $action->execute(['keyword' => substr($page->body, 8, 24)])->count());
    }
}
