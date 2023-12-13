<?php

namespace App\Http\Controllers\Dashboard\Peta;

use App\Actions\Peta\Kategori\KategoriDeleteAction;
use App\Actions\Peta\Kategori\KategoriPaginateAction;
use App\Actions\Peta\Kategori\KategoriStoreAction;
use App\Actions\Peta\Kategori\KategoriUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Peta\PetaKategori;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PetaKategori::class, 'kategori');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, KategoriPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $kategori = $index->execute($payload);

        if ($kategori instanceof LengthAwarePaginator) {
            $kategori->appends($request->query());
        }

        return Inertia::render('Dashboard/Peta/Kategori/Index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Peta/Kategori/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, KategoriStoreAction $kategoriStoreAction)
    {
        /**
         * @var PetaKategori
         */
        $kategori = $kategoriStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.peta.kategori.index'), 201)

            ->banner(sprintf('Kategori Created', $kategori->nama));
    }

    /**
     * Display the specified resource.
     */
    public function show(PetaKategori $kategori)
    {
        return Inertia::render('Dashboard/Peta/Kategori/Show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetaKategori $kategori)
    {
        return Inertia::render('Dashboard/Peta/Kategori/Edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetaKategori $kategori, KategoriUpdateAction $kategoriUpdateAction)
    {
        $kategoriUpdateAction->prepare($kategori)->execute($request->all());

        return Response::see(route('dashboard.peta.kategori.show', $kategori->getKey()))

            ->banner(sprintf('Updated kategori "%s"', $kategori->nomor_kartu_kategori));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetaKategori $kategori, KategoriDeleteAction $kategoriDeleteAction)
    {
        $kategoriDeleteAction->prepare($kategori)->execute();

        return Response::see(route('dashboard.peta.kategori.index'))

            ->with('flash', compact('kategori'))
            ->dangerBanner(sprintf('Destroyed kategori "%s"', $kategori->nomor_kartu_kategori));
    }
}
