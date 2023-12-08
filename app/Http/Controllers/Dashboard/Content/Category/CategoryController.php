<?php

namespace App\Http\Controllers\Dashboard\Content\Category;

use App\Actions\Content\Category\CategoryChildsPaginateAction;
use App\Actions\Content\Category\CategoryDeleteAction;
use App\Actions\Content\Category\CategoryPaginateAction;
use App\Actions\Content\Category\CategoryStoreAction;
use App\Actions\Content\Category\CategoryUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Content\ContentCategory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ContentCategory::class, 'category');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CategoryPaginateAction $categoryPaginateAction)
    {
        $payload = [
            'limit' => $request->get('limit', 8),
            'relationsCount' => ['articles', 'pages', 'childs'],
        ];

        if (!empty($keyword = $request->get('keyword'))) {
            $payload['keyword'] = $keyword;
        }

        /**
         * @var LengthAwarePaginator
         */
        $categories = $categoryPaginateAction

            ->execute($payload)
            ->appends($request->query());

        return Inertia::render('Dashboard/Content/Category/Index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Content/Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CategoryStoreAction $categoryStoreAction)
    {
        /**
         * @var ContentCategory
         */
        $category = $categoryStoreAction->execute($request->all());

        return Response::redirectToRoute('dashboard.content.category.index')

            ->with('flash', compact('category'))
            ->banner(sprintf('Category Created', $category->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        ContentCategory $category,
        CategoryChildsPaginateAction $categoryChildsPaginateAction
    ) {
        $childsPayload = [
            'limit' => $request->get('limit', 8),
            'relationsCount' => ['articles', 'pages', 'childs'],
        ];

        if (!empty($keyword = $request->get('keyword'))) {
            $childsPayload['keyword'] = $keyword;
        }

        /**
         * @var LengthAwarePaginator
         */
        $childs = $categoryChildsPaginateAction

            ->prepare($category)
            ->execute($childsPayload)
            ->appends($request->query());

        return Inertia::render('Dashboard/Content/Category/Show', compact('category', 'childs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentCategory $category)
    {
        return Inertia::render('Dashboard/Content/Category/Edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentCategory $category, CategoryUpdateAction $categoryUpdateAction)
    {
        $categoryUpdateAction->prepare($category)->execute($request->all());

        return Response::redirectToRoute('dashboard.content.category.show', $category->getKey())

            ->with('flash', compact('category'))
            ->banner(sprintf('Category Updated', $category->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentCategory $category, CategoryDeleteAction $categoryDeleteAction)
    {
        $categoryDeleteAction->skipAllRules()->execute($category->only('id'));

        return Response::redirectToRoute('dashboard.content.category.index')

            ->with('flash', compact('category'))
            ->dangerBanner(sprintf('Destroyed category "%s"', $category->name));
    }
}
