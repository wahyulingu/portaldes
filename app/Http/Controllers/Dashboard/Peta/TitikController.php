<?php

namespace App\Http\Controllers\Dashboard\Peta;

use App\Actions\Peta\Titik\TitikDeleteAction;
use App\Actions\Peta\Titik\TitikPaginateAction;
use App\Actions\Peta\Titik\TitikStoreAction;
use App\Actions\Peta\Titik\TitikUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Peta\PetaTitik;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class TitikController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PetaTitik::class, 'titik');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, TitikPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $titik = $index->execute($payload);

        if ($titik instanceof LengthAwarePaginator) {
            $titik->appends($request->query());
        }

        return Inertia::render('Dashboard/Peta/Titik/Index', compact('titik'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Peta/Titik/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TitikStoreAction $titikStoreAction)
    {
        /**
         * @var PetaTitik
         */
        $titik = $titikStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.peta.titik.index'))

            ->with('flash', compact('titik'))
            ->banner(sprintf('Article Created', $titik->nama));
    }

    /**
     * Display the specified resource.
     */
    public function show(PetaTitik $titik)
    {
        return Inertia::render('Dashboard/Peta/Titik/Show', compact('titik'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetaTitik $titik)
    {
        return Inertia::render('Dashboard/Peta/Titik/Edit', compact('titik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetaTitik $titik, TitikUpdateAction $titikUpdateAction)
    {
        $titikUpdateAction->prepare($titik)->execute($request->all());

        return Response::see(route('dashboard.peta.titik.show', $titik->getKey()))

            ->banner(sprintf('Updated titik "%s"', $titik->nomor_kartu_titik));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetaTitik $titik, TitikDeleteAction $titikDeleteAction)
    {
        $titikDeleteAction->prepare($titik)->execute();

        return Response::see(route('dashboard.peta.titik.index'))

            ->with('flash', compact('titik'))
            ->dangerBanner(sprintf('Destroyed titik "%s"', $titik->nama));
    }
}
