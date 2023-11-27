<?php

namespace Tests\Feature\Http\Dashboard\Content;

use App\Enumerations\Moderation;
use App\Models\Content\ContentCategory;
use App\Models\Content\ContentPage;
use App\Models\User;
use App\Repositories\FileRepository;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfPagesCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.page'));

        $this

            ->actingAs($user)
            ->get('/dashboard/content/page/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Page/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfPages(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/page/create')
            ->assertForbidden();
    }

    public function testCanStoreNewPage(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.page'));

        $page = [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/content/page', $page)
            ->assertRedirectToRoute('dashboard.content.page.index');

        $this->assertDatabaseHas(ContentPage::class, $page);
    }

    public function testCanStoreCategorizedPage(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.page'));

        $page = [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
            'category_id' => ContentCategory::factory()->create()->getKey(),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/content/page', $page)
            ->assertRedirectToRoute('dashboard.content.page.index');

        $this->assertDatabaseHas(ContentPage::class, $page);
    }

    public function testCanStoreThumbnailedPage(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.page'));

        /** @var FilesystemAdapter */
        $fakeStorage = app(FileRepository::class)->fake();

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');

        $page = [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/content/page', [
                ...$page,
                'thumbnail' => $thumbnail,
            ])

            ->assertRedirectToRoute('dashboard.content.page.index');

        $fakeStorage->assertExists($thumbnail->hashName('content/thumbnails'));

        $this->assertDatabaseHas(ContentPage::class, $page);
    }

    public function testCanStoreStatusedPage(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.page'));

        $page = [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
            'status' => Moderation::draft->name,
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/content/page', $page)

            ->assertRedirectToRoute('dashboard.content.page.index');

        $this->assertDatabaseHas(ContentPage::class, $page);
    }

    public function testOnlyAuthorizedUserCanStoreNewPage(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/content/page')
            ->assertForbidden();
    }

    public function testIndexScreenOfPagesCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.content.page'));

        ContentPage::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/content/page')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Page/Index')
                ->has('pages', fn (AssertableInertia $pages) => $pages
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testPagesCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.content.page'));

        /**
         * @var ContentPage
         */
        $page = ContentPage::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/page?keyword=%s', substr($page->description, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Page/Index')
                ->has('pages', fn (AssertableInertia $pages) => $pages
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfPages(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/page')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedPageCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var ContentPage
         */
        $page = ContentPage::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.content.page'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/page/%s/edit', $page->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Page/Edit')
                ->has('page', fn (AssertableInertia $pages) => $pages
                    ->where('id', $page->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedPage(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/page')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedPage(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.content.page'));

        $page = ContentPage::factory()->create();

        $newData = [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/content/page/%s', $page->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.content.page.show', $page->getKey());

        $this->assertDatabaseHas(ContentPage::class, [...$newData, 'id' => $page->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedPage(): void
    {
        $user = User::factory()->create();

        $page = ContentPage::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/content/page/%s', $page->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedPageCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.content.page'));

        $page = ContentPage::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/page/%s', $page->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Page/Show')
                ->has('page', fn (AssertableInertia $renderedPage) => $renderedPage
                    ->where('id', $page->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedPage(): void
    {
        $user = User::factory()->create();

        $page = ContentPage::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/page/%s', $page->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedPage(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.content.page'));

        $page = ContentPage::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/content/page/%s', $page->getKey()))
            ->assertRedirectToRoute('dashboard.content.page.index');

        $this->assertNull($page->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedPage(): void
    {
        $user = User::factory()->create();

        $page = ContentPage::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/content/page/%s', $page->getKey()))
            ->assertForbidden();
    }
}
