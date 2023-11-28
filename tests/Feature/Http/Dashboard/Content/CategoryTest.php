<?php

namespace Tests\Feature\Http\Dashboard\Content;

use App\Models\Content\ContentCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfCategoriesCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.category'));

        $this

            ->actingAs($user)
            ->get('/dashboard/content/category/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Category/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfCategories(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/category/create')
            ->assertForbidden();
    }

    public function testCreateScreenOfSubcategoriesCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.category'));

        $this

            ->actingAs($user)

            ->get(route(
                'dashboard.content.category.subcategory.create',
                $category->getKey(),
                absolute: false
            ))

            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Category/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfSubcategories(): void
    {
        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();

        $this

            ->actingAs(User::factory()->create())

            ->get(route(
                'dashboard.content.category.subcategory.create',
                $category->getKey(),
                absolute: false
            ))

            ->assertForbidden();
    }

    public function testCanStoreNewCategory(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.category'));

        $category = [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/content/category', $category)
            ->assertRedirectToRoute('dashboard.content.category.index');

        $this->assertDatabaseHas(ContentCategory::class, $category);
    }

    public function testCanStoreNewSubcategory(): void
    {
        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();

        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.category'));

        $subcategory = [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)

            ->post(
                uri: route(
                    'dashboard.content.category.subcategory.store',
                    $category->getKey(),
                    absolute: false
                ),

                data: $subcategory
            )

            ->assertRedirectToRoute('dashboard.content.category.show', $category->getKey());

        $this->assertDatabaseHas(ContentCategory::class, $subcategory);
    }

    public function testOnlyAuthorizedUserCanStoreNewCategoryOrSubcategory(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/content/category')
            ->assertForbidden();
    }

    public function testIndexScreenOfCategoriesCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.content.category'));

        ContentCategory::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/content/category')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Category/Index')
                ->has('categories', fn (AssertableInertia $categories) => $categories
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testCategoriesCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.content.category'));

        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/category?keyword=%s', substr($category->description, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Category/Index')
                ->has('categories', fn (AssertableInertia $categories) => $categories
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfCategories(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/category')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedCategoryCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var ContentCategory
         */
        $category = ContentCategory::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.content.category'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/category/%s/edit', $category->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Category/Edit')
                ->has('category', fn (AssertableInertia $categories) => $categories
                    ->where('id', $category->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedCategory(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/category')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedCategory(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.content.category'));

        $category = ContentCategory::factory()->create();

        $newData = [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/content/category/%s', $category->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.content.category.show', $category->getKey());

        $this->assertDatabaseHas(ContentCategory::class, [...$newData, 'id' => $category->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedCategory(): void
    {
        $user = User::factory()->create();

        $category = ContentCategory::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/content/category/%s', $category->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedCategoryCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.content.category'));

        $category = ContentCategory::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/category/%s', $category->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Category/Show')
                ->has('category', fn (AssertableInertia $renderedCategory) => $renderedCategory
                    ->where('id', $category->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedCategory(): void
    {
        $user = User::factory()->create();

        $category = ContentCategory::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/category/%s', $category->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedCategory(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.content.category'));

        $category = ContentCategory::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/content/category/%s', $category->getKey()))
            ->assertRedirectToRoute('dashboard.content.category.index');

        $this->assertNull($category->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedCategory(): void
    {
        $user = User::factory()->create();

        $category = ContentCategory::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/content/category/%s', $category->getKey()))
            ->assertForbidden();
    }
}
