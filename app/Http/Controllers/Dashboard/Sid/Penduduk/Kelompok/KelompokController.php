<?php

namespace App\Http\Controllers\Dashboard\Sid\Penduduk\Kelompok;

use App\Actions\Sid\Penduduk\Kelompok\KelompokDeleteAction;
use App\Actions\Sid\Penduduk\Kelompok\KelompokPaginateAction;
use App\Actions\Sid\Penduduk\Kelompok\KelompokStoreAction;
use App\Actions\Sid\Penduduk\Kelompok\KelompokUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompok;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class KelompokController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidPendudukKelompok::class, 'kelompok');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, KelompokPaginateAction $kelompokPaginateAction)
    {
        $payload = [
            'limit' => $request->get('limit', 8),
            'relationsCount' => ['articles', 'pages', 'childs'],
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

        return Inertia::render('Dashboard/Sid/Penduduk/Kelompok/Kelompok/Index', compact('kelompok'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Penduduk/Kelompok/Kelompok/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, KelompokStoreAction $kelompokStoreAction)
    {
        /**
         * @var SidPendudukKelompok
         */
        $kelompok = $kelompokStoreAction->execute($request->all());

        return Response::redirectToRoute('dashboard.sid.penduduk.kelompok.kelompok.index')

            ->with('flash', compact('kelompok'))
            ->banner(sprintf('Kelompok Created', $kelompok->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        SidPendudukKelompok $kelompok
    ) {
        $childsPayload = [
            'limit' => $request->get('limit', 8),
            'relationsCount' => ['articles', 'pages', 'childs'],
        ];

        if (!empty($keyword = $request->get('keyword'))) {
            $childsPayload['keyword'] = $keyword;
        }

        return Inertia::render('Dashboard/Sid/Penduduk/Kelompok/Kelompok/Show', compact('kelompok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidPendudukKelompok $kelompok)
    {
        return Inertia::render('Dashboard/Sid/Penduduk/Kelompok/Kelompok/Edit', compact('kelompok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidPendudukKelompok $kelompok, KelompokUpdateAction $kelompokUpdateAction)
    {
        $kelompokUpdateAction->prepare($kelompok)->execute($request->all());

        return Response::redirectToRoute('dashboard.sid.penduduk.kelompok.kelompok.show', $kelompok->getKey())

            ->with('flash', compact('kelompok'))
            ->banner(sprintf('Kelompok Updated', $kelompok->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidPendudukKelompok $kelompok, KelompokDeleteAction $kelompokDeleteAction)
    {
        $kelompokDeleteAction->skipAllRules()->execute($kelompok->only('id'));

        return Response::redirectToRoute('dashboard.sid.penduduk.kelompok.kelompok.index')

            ->with('flash', compact('kelompok'))
            ->dangerBanner(sprintf('Destroyed kelompok "%s"', $kelompok->name));
    }
}
