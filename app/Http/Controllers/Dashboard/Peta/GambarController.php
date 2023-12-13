<?php

namespace App\Http\Controllers\Dashboard\Peta;

use App\Actions\Peta\Gambar\GambarDeleteAction;
use App\Actions\Peta\Gambar\GambarPaginateAction;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Peta\PetaGambar;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class GambarController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PetaGambar::class, 'gambar');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GambarPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $gambar = $index->execute($payload);

        if ($gambar instanceof LengthAwarePaginator) {
            $gambar->appends($request->query());
        }

        return Inertia::render('Dashboard/Peta/Gambar/Index', compact('gambar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Peta/Gambar/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, GambarStoreAction $gambarStoreAction)
    {
        /**
         * @var PetaGambar
         */
        $gambar = $gambarStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.peta.gambar.show', $gambar->getKey()), 201)

            ->banner(sprintf('Gambar Created', $gambar->nomor_kartu_gambar));
    }

    /**
     * Display the specified resource.
     */
    public function show(PetaGambar $gambar)
    {
        return Inertia::render('Dashboard/Peta/Gambar/Show', compact('gambar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetaGambar $gambar)
    {
        return Inertia::render('Dashboard/Peta/Gambar/Edit', compact('gambar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetaGambar $gambar, GambarUpdateAction $gambarUpdateAction)
    {
        $gambarUpdateAction->prepare($gambar)->execute($request->all());

        return Response::see(route('dashboard.peta.gambar.show', $gambar->getKey()))

            ->banner(sprintf('Updated gambar "%s"', $gambar->nomor_kartu_gambar));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetaGambar $gambar, GambarDeleteAction $gambarDeleteAction)
    {
        $gambarDeleteAction->prepare($gambar)->execute();

        return Response::see(route('dashboard.peta.gambar.index'))

            ->with('flash', compact('gambar'))
            ->dangerBanner(sprintf('Destroyed gambar "%s"', $gambar->nomor_kartu_gambar));
    }
}
