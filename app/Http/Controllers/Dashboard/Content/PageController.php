<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Actions\Content\Page\PageDeleteAction;
use App\Actions\Content\Page\PagePaginateAction;
use App\Actions\Content\Page\PageStoreAction;
use App\Actions\Content\Page\PageUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Content\ContentPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class PageController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ContentPage::class, 'page');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PagePaginateAction $pagePaginateAction)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        return Inertia::render('Dashboard/Content/Page/Index', [
            'pages' => $pagePaginateAction->execute($payload),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Content/Page/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PageStoreAction $store)
    {
        $page = $store->execute([...$request->all(), 'user_id' => $request->user()->getKey()]);

        return Response::redirectToRoute('dashboard.content.page.index')

            ->with('flash', compact('page'))
            ->banner(sprintf('Lingkungan Created', $page->title));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentPage $page)
    {
        return Inertia::render('Dashboard/Content/Page/Show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentPage $page)
    {
        return Inertia::render('Dashboard/Content/Page/Edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentPage $page, PageUpdateAction $update)
    {
        $update->prepare($page)->execute($request->all());

        return Response::redirectToRoute('dashboard.content.page.show', $page->getKey())

            ->with('flash', compact('page'))
            ->banner(sprintf('Lingkungan Created', $page->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentPage $page, PageDeleteAction $pageDeleteAction)
    {
        $pageDeleteAction->prepare($page)->execute();

        return Response::redirectToRoute('dashboard.content.page.index')

            ->with('flash', compact('page'))
            ->banner(sprintf('Lingkungan Created', $page->title));
    }
}
