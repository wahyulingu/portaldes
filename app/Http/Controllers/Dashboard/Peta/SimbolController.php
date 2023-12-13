<?php

namespace App\Http\Controllers\Dashboard\Peta;

use App\Actions\Peta\Simbol\SimbolDeleteAction;
use App\Actions\Peta\Simbol\SimbolPaginateAction;
use App\Actions\Peta\Simbol\SimbolStoreAction;
use App\Actions\Peta\Simbol\SimbolUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Peta\PetaSimbol;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class SimbolController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PetaSimbol::class, 'simbol');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, SimbolPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $simbol = $index->execute($payload);

        if ($simbol instanceof LengthAwarePaginator) {
            $simbol->appends($request->query());
        }

        return Inertia::render('Dashboard/Peta/Simbol/Index', compact('simbol'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Peta/Simbol/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, SimbolStoreAction $simbolStoreAction)
    {
        /**
         * @var PetaSimbol
         */
        $simbol = $simbolStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.peta.simbol.index'), 201)

            ->banner(sprintf('Simbol Created', $simbol->nama));
    }

    /**
     * Display the specified resource.
     */
    public function show(PetaSimbol $simbol)
    {
        return Inertia::render('Dashboard/Peta/Simbol/Show', compact('simbol'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetaSimbol $simbol)
    {
        return Inertia::render('Dashboard/Peta/Simbol/Edit', compact('simbol'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetaSimbol $simbol, SimbolUpdateAction $simbolUpdateAction)
    {
        $simbolUpdateAction->prepare($simbol)->execute($request->all());

        return Response::see(route('dashboard.peta.simbol.show', $simbol->getKey()))

            ->banner(sprintf('Updated simbol "%s"', $simbol->nomor_kartu_simbol));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetaSimbol $simbol, SimbolDeleteAction $simbolDeleteAction)
    {
        $simbolDeleteAction->prepare($simbol)->execute();

        return Response::see(route('dashboard.peta.simbol.index'))

            ->with('flash', compact('simbol'))
            ->dangerBanner(sprintf('Destroyed simbol "%s"', $simbol->nomor_kartu_simbol));
    }
}
