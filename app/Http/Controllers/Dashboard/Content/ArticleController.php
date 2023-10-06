<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Actions\Content\Article\ArticleDeleteAction;
use App\Actions\Content\Article\ArticleStoreAction;
use App\Actions\Content\Article\ArticleUpdateAction;
use App\Actions\Content\Article\Index\ArticleIndexAction;
use App\Http\Controllers\Controller;
use App\Models\Content\ContentArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ContentArticle::class, 'article');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ArticleIndexAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        return Inertia::render('Dashboard/Content/Article/Index', [
            'articles' => $index->execute($payload),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Content/Article/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ArticleStoreAction $store)
    {
        $article = $store->prepare($request->user())->execute($request->all());

        return Response::redirectToRoute('dashboard.content.article.index', status: 201)

            ->with('flash', compact('article'))
            ->banner(sprintf('Lingkungan Created', $article->title));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentArticle $article)
    {
        return Inertia::render('Dashboard/Content/Article/Show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentArticle $article)
    {
        return Inertia::render('Dashboard/Content/Article/Edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentArticle $article, ArticleUpdateAction $update)
    {
        $update->prepare($article)->execute($request->all());

        return Response::redirectToRoute('dashboard.content.article.show', $article->getKey())

            ->with('flash', compact('article'))
            ->banner(sprintf('Lingkungan Created', $article->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentArticle $article, ArticleDeleteAction $articleDeleteAction)
    {
        $articleDeleteAction->prepare($article)->execute();

        return Response::redirectToRoute('dashboard.content.article.index')

            ->with('flash', compact('article'))
            ->banner(sprintf('Lingkungan Created', $article->title));
    }
}
