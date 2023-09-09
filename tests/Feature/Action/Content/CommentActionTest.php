<?php

namespace Tests\Feature\Action\Content;

use App\Actions\Content\Comment\CommentDeleteAction;
use App\Actions\Content\Comment\CommentStoreAction;
use App\Actions\Content\Comment\CommentUpdateAction;
use App\Actions\Content\Comment\Index\CommentIndexAction;
use App\Actions\Content\Comment\Index\CommentIndexByKeywordAction;
use App\Models\Content\ContentArticle;
use App\Models\Content\ContentComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentActionTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testCanStoreNewComment(): void
    {
        /**
         * @var CommentStoreAction
         */
        $action = app(CommentStoreAction::class);

        $action

            ->prepare(
                user: User::factory()->create(),
                content: ContentArticle::factory()->create()
            )

            ->execute($contentData = [
                'body' => ucfirst($this->faker->words(24, true)),
            ]);

        $this->assertDatabaseHas('content_comments', $contentData);
    }

    public function testCanUpdateExistingComment(): void
    {
        /**
         * @var ContentComment
         */
        $comment = ContentComment::factory()->create();

        /**
         * @var CommentUpdateAction
         */
        $action = app(CommentUpdateAction::class);

        $contentData = [
            'body' => ucfirst($this->faker->words(8, true)),
        ];

        $action->prepare($comment)->execute($contentData);

        $this->assertDatabaseHas('content_comments', [...$contentData, 'id' => $comment->getKey()]);
    }

    public function testCanDeleteExistingComment(): void
    {
        /**
         * @var ContentComment
         */
        $comment = ContentComment::factory()->create();

        /**
         * @var CommentDeleteAction
         */
        $deleteAction = app(CommentDeleteAction::class);

        $deleteAction->prepare($comment)->execute();

        $this->assertNull($comment->fresh());
    }

    public function testCommentCanIndex()
    {
        /**
         * @var CommentIndexAction
         */
        $action = app(CommentIndexAction::class);

        /**
         * @var ContentComment
         */
        $comment = ContentComment::factory()->create();

        $this->assertGreaterThan(0, $action->execute()->count());
    }

    public function testCommentCanIndexByKeyword()
    {
        /**
         * @var CommentIndexByKeywordAction
         */
        $action = app(CommentIndexByKeywordAction::class);

        /**
         * @var ContentComment
         */
        $comment = ContentComment::factory()->create();

        $this->assertGreaterThan(0, $action->execute(['keyword' => substr($comment->description, 8, 24)])->count());
    }
}
