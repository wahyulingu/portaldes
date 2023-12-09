<?php

namespace App\Http\Controllers\Dashboard\Content\Category;

use App\Actions\Content\Category\CategoryStoreAction;
use App\Http\Controllers\Controller;
use App\Models\Content\ContentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ContentCategory::class, 'category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ContentCategory $category)
    {
        return Inertia::render('Dashboard/Content/Category/Create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ContentCategory $category, CategoryStoreAction $categoryStoreAction)
    {
        /**
         * @var ContentCategory
         */
        $subcategory = $categoryStoreAction

            ->skipRules(['parent_id'])
            ->execute([
                ...$request->all(),
                'parent_id' => $category->getKey(),
            ]);

        return Response::redirectToRoute('dashboard.content.category.show', $category->getKey())

            ->with('flash', compact('subcategory'))
            ->banner(sprintf('Subcategory Created', $subcategory->name));
    }
}
