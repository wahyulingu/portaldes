<?php

namespace App\Http\Controllers\Dashboard\Sid\Kelompok;

use App\Actions\Sid\Kelompok\KelompokDeleteAction;
use App\Actions\Sid\Kelompok\KelompokPaginateAction;
use App\Actions\Sid\Kelompok\KelompokStoreAction;
use App\Actions\Sid\Kelompok\KelompokUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\Kelompok\SidKelompok;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class KelompokController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidKelompok::class, 'kelompok');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, KelompokPaginateAction $kelompokPaginateAction)
    {
        $payload = [
            'limit' => $request->get('limit', 8),
            'relationsCount' => ['penduduk'],
            'relations' => ['ketua'],
        ];

        if (!empty($keyword = $request->get('keyword'))) {
            $payload['keyword'] = $keyword;
        }

        /**
         * @var LengthAwarePaginator
         */
        $kelompok = $kelompokPaginateAction

            ->execute($payload)
            ->appends($request->query());

        return Inertia::render('Dashboard/Sid/Kelompok/Index', compact('kelompok'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Kelompok/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, KelompokStoreAction $kelompokStoreAction)
    {
        /**
         * @var SidKelompok
         */
        $kelompok = $kelompokStoreAction->execute($request->all());

        return Response::redirectToRoute('dashboard.sid.kelompok.index')

            ->with('flash', compact('kelompok'))
            ->banner(sprintf('Kelompok Created', $kelompok->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SidKelompok $kelompok)
    {
        $kelompok->load(['penduduk', 'ketua']);

        return Inertia::render('Dashboard/Sid/Kelompok/Show', compact('kelompok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidKelompok $kelompok)
    {
        return Inertia::render('Dashboard/Sid/Kelompok/Edit', compact('kelompok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidKelompok $kelompok, KelompokUpdateAction $kelompokUpdateAction)
    {
        $kelompokUpdateAction->prepare($kelompok)->execute($request->all());

        return Response::redirectToRoute('dashboard.sid.kelompok.show', $kelompok->getKey())

            ->with('flash', compact('kelompok'))
            ->banner(sprintf('Kelompok Updated', $kelompok->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidKelompok $kelompok, KelompokDeleteAction $kelompokDeleteAction)
    {
        $kelompokDeleteAction->prepare($kelompok)->execute($kelompok->only('id'));

        return Response::redirectToRoute('dashboard.sid.kelompok.index')

            ->with('flash', compact('kelompok'))
            ->dangerBanner(sprintf('Destroyed kelompok "%s"', $kelompok->name));
    }
}
