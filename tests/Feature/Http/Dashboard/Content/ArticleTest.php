<?php

namespace Tests\Feature\Http\Dashboard\Content;

use App\Models\Content\ContentArticle;
use App\Models\Content\ContentCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateScreenOfArticlesCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.article'));

        $this

            ->actingAs($user)
            ->get('/dashboard/content/article/create')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Article/Create'));
    }

    public function testOnlyAuthorizedUserCanAccessCreateScreenOfArticles(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/article/create')
            ->assertForbidden();
    }

    public function testCanStoreNewArticle(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.article'));

        $article = [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/content/article', $article)
            ->assertSuccessful();

        $this->assertDatabaseHas(ContentArticle::class, $article);
    }

    public function testCanStoreCategorizedArticle(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('create.content.article'));

        $article = [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
            'category_id' => ContentCategory::factory()->create()->getKey(),
        ];

        $this

            ->actingAs($user)
            ->post('/dashboard/content/article', $article)
            ->assertSuccessful();

        $this->assertDatabaseHas(ContentArticle::class, $article);
    }

    public function testOnlyAuthorizedUserCanStoreNewArticleOrSubarticle(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->post('/dashboard/content/article')
            ->assertForbidden();
    }

    public function testIndexScreenOfArticlesCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.content.article'));

        ContentArticle::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/content/article')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Article/Index')
                ->has('articles', fn (AssertableInertia $articles) => $articles
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testArticlesCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.content.article'));

        /**
         * @var ContentArticle
         */
        $article = ContentArticle::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/article?keyword=%s', substr($article->description, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Article/Index')
                ->has('articles', fn (AssertableInertia $articles) => $articles
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfArticles(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/article')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedArticleCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var ContentArticle
         */
        $article = ContentArticle::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.content.article'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/article/%s/edit', $article->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Article/Edit')
                ->has('article', fn (AssertableInertia $articles) => $articles
                    ->where('id', $article->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedArticle(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/article')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedArticle(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.content.article'));

        $article = ContentArticle::factory()->create();

        $newData = [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->words(8, true),
            'body' => $this->faker->paragraphs(8, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/content/article/%s', $article->getKey()), $newData)
            ->assertRedirectToRoute('dashboard.content.article.show', $article->getKey());

        $this->assertDatabaseHas(ContentArticle::class, [...$newData, 'id' => $article->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedArticle(): void
    {
        $user = User::factory()->create();

        $article = ContentArticle::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/content/article/%s', $article->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedArticleCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.content.article'));

        $article = ContentArticle::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/article/%s', $article->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Article/Show')
                ->has('article', fn (AssertableInertia $renderedArticle) => $renderedArticle
                    ->where('id', $article->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedArticle(): void
    {
        $user = User::factory()->create();

        $article = ContentArticle::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/article/%s', $article->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedArticle(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.content.article'));

        $article = ContentArticle::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/content/article/%s', $article->getKey()))
            ->assertRedirectToRoute('dashboard.content.article.index');

        $this->assertNull($article->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedArticle(): void
    {
        $user = User::factory()->create();

        $article = ContentArticle::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/content/article/%s', $article->getKey()))
            ->assertForbidden();
    }
}
