<?php

namespace App\Http\Controllers\Dashboard\Peta;

use App\Actions\Peta\Warna\WarnaDeleteAction;
use App\Actions\Peta\Warna\WarnaPaginateAction;
use App\Actions\Peta\Warna\WarnaStoreAction;
use App\Actions\Peta\Warna\WarnaUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Peta\PetaWarna;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class WarnaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PetaWarna::class, 'warna');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, WarnaPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $warna = $index->execute($payload);

        if ($warna instanceof LengthAwarePaginator) {
            $warna->appends($request->query());
        }

        return Inertia::render('Dashboard/Peta/Warna/Index', compact('warna'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Peta/Warna/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, WarnaStoreAction $warnaStoreAction)
    {
        /**
         * @var PetaWarna
         */
        $warna = $warnaStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.peta.warna.index'), 201)

            ->banner(sprintf('Warna Created', $warna->nama));
    }

    /**
     * Display the specified resource.
     */
    public function show(PetaWarna $warna)
    {
        return Inertia::render('Dashboard/Peta/Warna/Show', compact('warna'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetaWarna $warna)
    {
        return Inertia::render('Dashboard/Peta/Warna/Edit', compact('warna'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetaWarna $warna, WarnaUpdateAction $warnaUpdateAction)
    {
        $warnaUpdateAction->prepare($warna)->execute($request->all());

        return Response::see(route('dashboard.peta.warna.show', $warna->getKey()))

            ->banner(sprintf('Updated warna "%s"', $warna->nomor_kartu_warna));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetaWarna $warna, WarnaDeleteAction $warnaDeleteAction)
    {
        $warnaDeleteAction->prepare($warna)->execute();

        return Response::see(route('dashboard.peta.warna.index'))

            ->with('flash', compact('warna'))
            ->dangerBanner(sprintf('Destroyed warna "%s"', $warna->nomor_kartu_warna));
    }
}
