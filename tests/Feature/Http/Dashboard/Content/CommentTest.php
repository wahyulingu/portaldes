<?php

namespace Tests\Feature\Http\Dashboard\Content;

use App\Models\Content\ContentComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndexScreenOfCommentsCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.content.comment'));

        ContentComment::factory(5)->create();

        $this

            ->actingAs($user)
            ->get('/dashboard/content/comment')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Comment/Index')
                ->has('comments', fn (AssertableInertia $comments) => $comments
                    ->has('data', 5, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 5)
                    ->etc()));
    }

    public function testCommentsCanIndexByKeyword(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('viewAny.content.comment'));

        /**
         * @var ContentComment
         */
        $comment = ContentComment::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/comment?keyword=%s', substr($comment->description, 8, 24)))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Comment/Index')
                ->has('comments', fn (AssertableInertia $comments) => $comments
                    ->has('data', 1, fn (AssertableInertia $data) => $data
                        ->etc())
                    ->where('total', 1)
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessIndexScreenOfComments(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/comment')
            ->assertForbidden();
    }

    public function testEditScreenOfSelectedCommentCanBeRendered(): void
    {
        $user = User::factory()->create();

        /**
         * @var ContentComment
         */
        $comment = ContentComment::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.content.comment'));

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/comment/%s/edit', $comment->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Comment/Edit')
                ->has('comment', fn (AssertableInertia $comments) => $comments
                    ->where('id', $comment->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessEditScreenOfSelectedComment(): void
    {
        $this

            ->actingAs(User::factory()->create())
            ->get('/dashboard/content/comment')
            ->assertForbidden();
    }

    public function testCanUpdateSelectedComment(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('update.content.comment'));

        $comment = ContentComment::factory()->create();

        $newData = [
            'body' => $this->faker->words(24, true),
        ];

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/content/comment/%s', $comment->getKey()), $newData)
            ->assertSuccessful();

        $this->assertDatabaseHas(ContentComment::class, [...$newData, 'id' => $comment->getKey()]);
    }

    public function testOnlyAuthorizedUserCanUpdateSelectedComment(): void
    {
        $user = User::factory()->create();

        $comment = ContentComment::factory()->create();

        $this

            ->actingAs($user)
            ->patch(sprintf('/dashboard/content/comment/%s', $comment->getKey()))
            ->assertForbidden();
    }

    public function testShowScreenOfSelectedCommentCanBeRendered(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('view.content.comment'));

        $comment = ContentComment::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/comment/%s', $comment->getKey()))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard/Content/Comment/Show')
                ->has('comment', fn (AssertableInertia $renderedComment) => $renderedComment
                    ->where('id', $comment->getKey())
                    ->etc()));
    }

    public function testOnlyAuthorizedUserCanAccessShowScreenOfSelectedComment(): void
    {
        $user = User::factory()->create();

        $comment = ContentComment::factory()->create();

        $this

            ->actingAs($user)
            ->get(sprintf('/dashboard/content/comment/%s', $comment->getKey()))
            ->assertForbidden();
    }

    public function testCanDestroySelectedComment(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo(Permission::findOrCreate('delete.content.comment'));

        $comment = ContentComment::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/content/comment/%s', $comment->getKey()))
            ->assertOk();

        $this->assertNull($comment->fresh());
    }

    public function testOnlyAuthorizedUserCanDestroySelectedComment(): void
    {
        $user = User::factory()->create();

        $comment = ContentComment::factory()->create();

        $this

            ->actingAs($user)
            ->delete(sprintf('/dashboard/content/comment/%s', $comment->getKey()))
            ->assertForbidden();
    }
}
