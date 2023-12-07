<?php

namespace App\Http\Controllers\Dashboard\Sid\Wilayah;

use App\Actions\Sid\Penduduk\PendudukIndexAction;
use App\Actions\Sid\Wilayah\Lingkungan\LingkunganDeleteAction;
use App\Actions\Sid\Wilayah\Lingkungan\LingkunganPaginateAction;
use App\Actions\Sid\Wilayah\Lingkungan\LingkunganStoreAction;
use App\Actions\Sid\Wilayah\Lingkungan\LingkunganUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\Wilayah\SidWilayahLingkungan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class LingkunganController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidWilayahLingkungan::class, 'lingkungan');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LingkunganPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $lingkungan = $index->execute($payload);

        if ($lingkungan instanceof LengthAwarePaginator) {
            $lingkungan->appends($request->query());
        }

        return Inertia::render('Dashboard/Sid/Wilayah/Lingkungan/Index', compact('lingkungan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PendudukIndexAction $pendudukIndexAction)
    {
        $penduduk = $pendudukIndexAction->execute();

        return Inertia::render('Dashboard/Sid/Wilayah/Lingkungan/Create', compact('penduduk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, LingkunganStoreAction $lingkunganStoreAction)
    {
        /**
         * @var SidWilayahLingkungan
         */
        $lingkungan = $lingkunganStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.sid.wilayah.lingkungan.show', $lingkungan->getKey()), 201)

            ->banner(sprintf('Lingkungan Created', $lingkungan->nama));
    }

    /**
     * Display the specified resource.
     */
    public function show(SidWilayahLingkungan $lingkungan)
    {
        return Inertia::render('Dashboard/Sid/Wilayah/Lingkungan/Show', compact('lingkungan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidWilayahLingkungan $lingkungan, PendudukIndexAction $pendudukIndexAction)
    {
        $penduduk = $pendudukIndexAction->execute();

        return Inertia::render('Dashboard/Sid/Wilayah/Lingkungan/Edit', compact('lingkungan', 'penduduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidWilayahLingkungan $lingkungan, LingkunganUpdateAction $lingkunganUpdateAction)
    {
        $lingkunganUpdateAction->prepare($lingkungan)->execute($request->all());

        return Response::see(route('dashboard.sid.wilayah.lingkungan.show', $lingkungan->getKey()))

            ->banner(sprintf('Updated Lingkungan "%s"', $lingkungan->nama));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidWilayahLingkungan $lingkungan, LingkunganDeleteAction $lingkunganDeleteAction)
    {
        $lingkunganDeleteAction->prepare($lingkungan)->execute();

        return Response::see(route('dashboard.sid.wilayah.lingkungan.index'))

            ->with('flash', compact('lingkungan'))
            ->dangerBanner(sprintf('Destroyed Lingkungan "%s"', $lingkungan->nama));
    }
}
