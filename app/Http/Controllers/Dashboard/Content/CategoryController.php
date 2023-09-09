<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Actions\Content\Category\CategoryDeleteAction;
use App\Actions\Content\Category\CategoryStoreAction;
use App\Actions\Content\Category\CategoryUpdateAction;
use App\Actions\Content\Category\Index\CategoryIndexAction;
use App\Http\Controllers\Controller;
use App\Models\Content\ContentCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
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
    public function index(Request $request, CategoryIndexAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $categories = $index->execute($payload);

        if ($categories instanceof LengthAwarePaginator) {
            $categories->appends($request->query());
        }

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

        $response = Response::see(route('dashboard.content.category.show', $category->getKey()));

        return $response->banner(sprintf('Category Created', $category->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentCategory $category)
    {
        return Inertia::render('Dashboard/Content/Category/Show', compact('category'));
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

        $response = Response::see(route('dashboard.content.category.show', $category->getKey()));

        return $response->banner(sprintf('Updated category "%s"', $category->name));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentCategory $category, CategoryDeleteAction $categoryDeleteAction)
    {
        $categoryDeleteAction->prepare($category)->execute();

        return Response::see(route('dashboard.content.category.index'))

            ->with('flash', compact('category'))
            ->dangerBanner(sprintf('Destroyed category "%s"', $category->name));
    }
}
