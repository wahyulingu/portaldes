<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Actions\Content\Comment\CommentDeleteAction;
use App\Actions\Content\Comment\CommentUpdateAction;
use App\Actions\Content\Comment\Index\CommentPaginateAction;
use App\Http\Controllers\Controller;
use App\Models\Content\ContentComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ContentComment::class, 'comment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CommentPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        if ($status = $request->get('status')) {
            $payload['status'] = $status;
        }

        return Inertia::render('Dashboard/Content/Comment/Index', [
            'comments' => $index->execute($payload),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Content/Comment/Create');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentComment $comment)
    {
        return Inertia::render('Dashboard/Content/Comment/Show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentComment $comment)
    {
        return Inertia::render('Dashboard/Content/Comment/Edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentComment $comment, CommentUpdateAction $update)
    {
        $update->prepare($comment)->execute($request->all());

        return Response::redirectToRoute('dashboard.content.comment.show', $comment->getKey())

            ->with('flash', compact('comment'))
            ->banner(sprintf('Comment updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentComment $comment, CommentDeleteAction $commentDeleteAction)
    {
        $commentDeleteAction->skipAllRules()->execute($comment->only('id'));

        return Response::redirectToRoute('dashboard.content.comment.index')

            ->with('flash', compact('comment'))
            ->dangerBanner(sprintf('Destroyed comment "%s"', $comment->name));
    }
}
