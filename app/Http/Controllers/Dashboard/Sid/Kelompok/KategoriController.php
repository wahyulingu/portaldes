<?php

namespace App\Http\Controllers\Dashboard\Sid\Kelompok;

use App\Actions\Sid\Kelompok\Kategori\KategoriDeleteAction;
use App\Actions\Sid\Kelompok\Kategori\KategoriPaginateAction;
use App\Actions\Sid\Kelompok\Kategori\KategoriStoreAction;
use App\Actions\Sid\Kelompok\Kategori\KategoriUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\Kelompok\SidKelompokKategori;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidKelompokKategori::class, 'kategori');
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

        return Inertia::render('Dashboard/Sid/Kelompok/Kategori/Index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Kelompok/Kategori/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, KategoriStoreAction $kategoriStoreAction)
    {
        /**
         * @var SidKelompokKategori
         */
        $kategori = $kategoriStoreAction->execute($request->all());

        return Response::redirectToRoute('dashboard.sid.kelompok.kategori.index')

            ->with('flash', compact('kategori'))
            ->banner(sprintf('Kategori Created', $kategori->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        SidKelompokKategori $kategori
    ) {
        $childsPayload = [
            'limit' => $request->get('limit', 8),
            'relationsCount' => ['kelompok'],
        ];

        if (!empty($keyword = $request->get('keyword'))) {
            $childsPayload['keyword'] = $keyword;
        }

        return Inertia::render('Dashboard/Sid/Kelompok/Kategori/Show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidKelompokKategori $kategori)
    {
        return Inertia::render('Dashboard/Sid/Kelompok/Kategori/Edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidKelompokKategori $kategori, KategoriUpdateAction $kategoriUpdateAction)
    {
        $kategoriUpdateAction->prepare($kategori)->execute($request->all());

        return Response::redirectToRoute('dashboard.sid.kelompok.kategori.show', $kategori->getKey())

            ->with('flash', compact('kategori'))
            ->banner(sprintf('Kategori Updated', $kategori->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidKelompokKategori $kategori, KategoriDeleteAction $kategoriDeleteAction)
    {
        $kategoriDeleteAction->prepare($kategori)->execute($kategori->only('id'));

        return Response::redirectToRoute('dashboard.sid.kelompok.kategori.index')

            ->with('flash', compact('kategori'))
            ->dangerBanner(sprintf('Destroyed kategori "%s"', $kategori->name));
    }
}
