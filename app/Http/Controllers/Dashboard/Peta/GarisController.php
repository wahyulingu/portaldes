<?php

namespace App\Http\Controllers\Dashboard\Peta;

use App\Actions\Peta\Garis\GarisDeleteAction;
use App\Actions\Peta\Garis\GarisPaginateAction;
use App\Actions\Peta\Garis\GarisStoreAction;
use App\Actions\Peta\Garis\GarisUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Peta\PetaGaris;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class GarisController extends Controller
{
    protected $plural = false;

    public function __construct()
    {
        $this->authorizeResource(PetaGaris::class, 'garis');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GarisPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $garis = $index->execute($payload);

        if ($garis instanceof LengthAwarePaginator) {
            $garis->appends($request->query());
        }

        return Inertia::render('Dashboard/Peta/Garis/Index', compact('garis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Peta/Garis/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, GarisStoreAction $garisStoreAction)
    {
        /**
         * @var PetaGaris
         */
        $garis = $garisStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.peta.garis.index'), 201)

            ->banner(sprintf('Garis Created', $garis->nomor_kartu_garis));
    }

    /**
     * Display the specified resource.
     */
    public function show(PetaGaris $garis)
    {
        return Inertia::render('Dashboard/Peta/Garis/Show', compact('garis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetaGaris $garis)
    {
        return Inertia::render('Dashboard/Peta/Garis/Edit', compact('garis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetaGaris $garis, GarisUpdateAction $garisUpdateAction)
    {
        $garisUpdateAction->prepare($garis)->execute($request->all());

        return Response::see(route('dashboard.peta.garis.show', $garis->getKey()))

            ->banner(sprintf('Updated garis "%s"', $garis->nomor_kartu_garis));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetaGaris $garis, GarisDeleteAction $garisDeleteAction)
    {
        $garisDeleteAction->prepare($garis)->execute();

        return Response::see(route('dashboard.peta.garis.index'))

            ->with('flash', compact('garis'))
            ->dangerBanner(sprintf('Destroyed garis "%s"', $garis->nomor_kartu_garis));
    }
}
