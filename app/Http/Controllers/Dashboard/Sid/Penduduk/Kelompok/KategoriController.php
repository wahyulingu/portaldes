<?php

namespace App\Http\Controllers\Dashboard\Sid\Penduduk\Kelompok;

use App\Actions\Sid\Penduduk\Kelompok\Kategori\KategoriDeleteAction;
use App\Actions\Sid\Penduduk\Kelompok\Kategori\KategoriPaginateAction;
use App\Actions\Sid\Penduduk\Kelompok\Kategori\KategoriStoreAction;
use App\Actions\Sid\Penduduk\Kelompok\Kategori\KategoriUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompokKategori;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidPendudukKelompokKategori::class, 'kategori');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, KategoriPaginateAction $kategoriPaginateAction)
    {
        $payload = [
            'limit' => $request->get('limit', 8),
            'relationsCount' => ['kelompok'],
        ];

        if (!empty($keyword = $request->get('keyword'))) {
            $payload['keyword'] = $keyword;
        }

        /**
         * @var LengthAwarePaginator
         */
        $kategori = $kategoriPaginateAction

            ->execute($payload)
            ->appends($request->query());

        return Inertia::render('Dashboard/Sid/Penduduk/Kelompok/Kategori/Index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Penduduk/Kelompok/Kategori/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, KategoriStoreAction $kategoriStoreAction)
    {
        /**
         * @var SidPendudukKelompokKategori
         */
        $kategori = $kategoriStoreAction->execute($request->all());

        return Response::redirectToRoute('dashboard.sid.penduduk.kelompok.kategori.index')

            ->with('flash', compact('kategori'))
            ->banner(sprintf('Kategori Created', $kategori->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        SidPendudukKelompokKategori $kategori
    ) {
        $childsPayload = [
            'limit' => $request->get('limit', 8),
            'relationsCount' => ['kelompok'],
        ];

        if (!empty($keyword = $request->get('keyword'))) {
            $childsPayload['keyword'] = $keyword;
        }

        return Inertia::render('Dashboard/Sid/Penduduk/Kelompok/Kategori/Show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidPendudukKelompokKategori $kategori)
    {
        return Inertia::render('Dashboard/Sid/Penduduk/Kelompok/Kategori/Edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidPendudukKelompokKategori $kategori, KategoriUpdateAction $kategoriUpdateAction)
    {
        $kategoriUpdateAction->prepare($kategori)->execute($request->all());

        return Response::redirectToRoute('dashboard.sid.penduduk.kelompok.kategori.show', $kategori->getKey())

            ->with('flash', compact('kategori'))
            ->banner(sprintf('Kategori Updated', $kategori->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidPendudukKelompokKategori $kategori, KategoriDeleteAction $kategoriDeleteAction)
    {
        $kategoriDeleteAction->prepare($kategori)->execute($kategori->only('id'));

        return Response::redirectToRoute('dashboard.sid.penduduk.kelompok.kategori.index')

            ->with('flash', compact('kategori'))
            ->dangerBanner(sprintf('Destroyed kategori "%s"', $kategori->name));
    }
}
