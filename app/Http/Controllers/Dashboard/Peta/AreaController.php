<?php

namespace App\Http\Controllers\Dashboard\Peta;

use App\Actions\Peta\Area\AreaDeleteAction;
use App\Actions\Peta\Area\AreaPaginateAction;
use App\Actions\Peta\Area\AreaStoreAction;
use App\Actions\Peta\Area\AreaUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Peta\PetaArea;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PetaArea::class, 'area');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AreaPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $area = $index->execute($payload);

        if ($area instanceof LengthAwarePaginator) {
            $area->appends($request->query());
        }

        return Inertia::render('Dashboard/Peta/Area/Index', compact('area'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Peta/Area/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, AreaStoreAction $areaStoreAction)
    {
        /**
         * @var PetaArea
         */
        $area = $areaStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.peta.area.index'), 201)

            ->banner(sprintf('Area Created', $area->nama));
    }

    /**
     * Display the specified resource.
     */
    public function show(PetaArea $area)
    {
        return Inertia::render('Dashboard/Peta/Area/Show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetaArea $area)
    {
        return Inertia::render('Dashboard/Peta/Area/Edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetaArea $area, AreaUpdateAction $areaUpdateAction)
    {
        $areaUpdateAction->prepare($area)->execute($request->all());

        return Response::see(route('dashboard.peta.area.show', $area->getKey()))

            ->banner(sprintf('Updated area "%s"', $area->nomor_kartu_area));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetaArea $area, AreaDeleteAction $areaDeleteAction)
    {
        $areaDeleteAction->prepare($area)->execute();

        return Response::see(route('dashboard.peta.area.index'))

            ->with('flash', compact('area'))
            ->dangerBanner(sprintf('Destroyed area "%s"', $area->nomor_kartu_area));
    }
}
