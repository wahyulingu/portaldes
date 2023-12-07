<?php

namespace App\Http\Controllers\Dashboard\Sid\Wilayah;

use App\Actions\Sid\Penduduk\PendudukIndexAction;
use App\Actions\Sid\Wilayah\Lingkungan\LingkunganIndexAction;
use App\Actions\Sid\Wilayah\RukunWarga\RukunWargaDeleteAction;
use App\Actions\Sid\Wilayah\RukunWarga\RukunWargaPaginateAction;
use App\Actions\Sid\Wilayah\RukunWarga\RukunWargaStoreAction;
use App\Actions\Sid\Wilayah\RukunWarga\RukunWargaUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\Wilayah\SidWilayahRukunWarga;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class RukunWargaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidWilayahRukunWarga::class, 'rukun_warga');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, RukunWargaPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $rukun_warga = $index->execute($payload);

        if ($rukun_warga instanceof LengthAwarePaginator) {
            $rukun_warga->appends($request->query());
        }

        return Inertia::render('Dashboard/Sid/Wilayah/RukunWarga/Index', compact('rukun_warga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PendudukIndexAction $pendudukIndexAction, LingkunganIndexAction $lingkunganIndexAction)
    {
        $penduduk = $pendudukIndexAction->execute();
        $lingkungan = $lingkunganIndexAction->execute();

        return Inertia::render('Dashboard/Sid/Wilayah/RukunWarga/Create', compact('penduduk', 'lingkungan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, RukunWargaStoreAction $rukun_wargaStoreAction)
    {
        /**
         * @var SidWilayahRukunWarga
         */
        $rukun_warga = $rukun_wargaStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.sid.wilayah.rukun-warga.show', $rukun_warga->getKey()), 201)

            ->banner(sprintf('RukunWarga Created', $rukun_warga->nama));
    }

    /**
     * Display the specified resource.
     */
    public function show(SidWilayahRukunWarga $rukun_warga)
    {
        return Inertia::render('Dashboard/Sid/Wilayah/RukunWarga/Show', compact('rukun_warga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        SidWilayahRukunWarga $rukun_warga,
        PendudukIndexAction $pendudukIndexAction,
        LingkunganIndexAction $lingkunganIndexAction
    ) {
        $penduduk = $pendudukIndexAction->execute();
        $lingkungan = $lingkunganIndexAction->execute();

        return Inertia::render(
            'Dashboard/Sid/Wilayah/RukunWarga/Edit',
            compact('rukun_warga', 'penduduk', 'lingkungan')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidWilayahRukunWarga $rukun_warga, RukunWargaUpdateAction $rukun_wargaUpdateAction)
    {
        $rukun_wargaUpdateAction->prepare($rukun_warga)->execute($request->all());

        return Response::see(route('dashboard.sid.wilayah.rukun-warga.show', $rukun_warga->getKey()))

            ->banner(sprintf('Updated RukunWarga "%s"', $rukun_warga->nama));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidWilayahRukunWarga $rukun_warga, RukunWargaDeleteAction $rukun_wargaDeleteAction)
    {
        $rukun_wargaDeleteAction->prepare($rukun_warga)->execute();

        return Response::see(route('dashboard.sid.wilayah.rukun-warga.index'))

            ->with('flash', compact('rukun_warga'))
            ->dangerBanner(sprintf('Destroyed RukunWarga "%s"', $rukun_warga->nama));
    }
}
