<?php

namespace App\Http\Controllers\Dashboard\Sid;

use App\Actions\Sid\Keluarga\KeluargaDeleteAction;
use App\Actions\Sid\Keluarga\KeluargaPaginateAction;
use App\Actions\Sid\Keluarga\KeluargaStoreAction;
use App\Actions\Sid\Keluarga\KeluargaUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\SidKeluarga;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class KeluargaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidKeluarga::class, 'keluarga');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, KeluargaPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $keluarga = $index->execute($payload);

        if ($keluarga instanceof LengthAwarePaginator) {
            $keluarga->appends($request->query());
        }

        return Inertia::render('Dashboard/Sid/Keluarga/Index', compact('keluarga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Keluarga/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, KeluargaStoreAction $keluargaStoreAction)
    {
        /**
         * @var SidKeluarga
         */
        $keluarga = $keluargaStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.sid.keluarga.show', $keluarga->getKey()), 201)

            ->banner(sprintf('Keluarga Created', $keluarga->nomor_kartu_keluarga));
    }

    /**
     * Display the specified resource.
     */
    public function show(SidKeluarga $keluarga)
    {
        return Inertia::render('Dashboard/Sid/Keluarga/Show', compact('keluarga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidKeluarga $keluarga)
    {
        return Inertia::render('Dashboard/Sid/Keluarga/Edit', compact('keluarga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidKeluarga $keluarga, KeluargaUpdateAction $keluargaUpdateAction)
    {
        $keluargaUpdateAction->prepare($keluarga)->execute($request->all());

        return Response::see(route('dashboard.sid.keluarga.show', $keluarga->getKey()))

            ->banner(sprintf('Updated keluarga "%s"', $keluarga->nomor_kartu_keluarga));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidKeluarga $keluarga, KeluargaDeleteAction $keluargaDeleteAction)
    {
        $keluargaDeleteAction->prepare($keluarga)->execute();

        return Response::see(route('dashboard.sid.keluarga.index'))

            ->with('flash', compact('keluarga'))
            ->dangerBanner(sprintf('Destroyed keluarga "%s"', $keluarga->nomor_kartu_keluarga));
    }
}
