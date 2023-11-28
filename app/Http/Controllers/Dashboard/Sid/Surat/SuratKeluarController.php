<?php

namespace App\Http\Controllers\Dashboard\Sid\Surat;

use App\Actions\Sid\Surat\Keluar\SuratKeluarPaginateAction;
use App\Actions\Sid\Surat\Keluar\SuratKeluarStoreAction;
use App\Actions\Sid\Surat\Keluar\SuratKeluarUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\Surat\SidSurat;
use App\Models\Sid\Surat\SidSuratKeluar;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class SuratKeluarController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidSuratKeluar::class, 'surat_keluar');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, SuratKeluarPaginateAction $suratKeluarIndexAction)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $surat = $suratKeluarIndexAction->execute($payload);

        if ($surat instanceof LengthAwarePaginator) {
            $surat->appends($request->query());
        }

        return Inertia::render('Dashboard/Sid/Surat/Keluar/Index', compact('surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Surat/Keluar/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, SuratKeluarStoreAction $suratKeluarStoreAction)
    {
        /**
         * @var SidSurat
         */
        $suratKeluar = $suratKeluarStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.sid.surat.surat-keluar.show', $suratKeluar->getKey()), 201)

            ->banner(sprintf('Surat Created', $suratKeluar->surat->nomor_surat));
    }

    /**
     * Display the specified resource.
     */
    public function show(SidSuratKeluar $surat_keluar)
    {
        return Inertia::render('Dashboard/Sid/Surat/Keluar/Show', compact('surat_keluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidSuratKeluar $surat_keluar)
    {
        return Inertia::render('Dashboard/Sid/Surat/Keluar/Edit', compact('surat_keluar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidSuratKeluar $surat_keluar, SuratKeluarUpdateAction $suratKeluarUpdateAction)
    {
        $suratKeluarUpdateAction->prepare($surat_keluar)->execute($request->all());

        return Response::see(route('dashboard.sid.surat.surat-keluar.show', $surat_keluar->getKey()))

            ->banner(sprintf('Updated Surat "%s"', $surat_keluar->nama));
    }
}
