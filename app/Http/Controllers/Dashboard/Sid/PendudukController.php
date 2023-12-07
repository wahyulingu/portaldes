<?php

namespace App\Http\Controllers\Dashboard\Sid;

use App\Actions\Sid\Penduduk\PendudukDeleteAction;
use App\Actions\Sid\Penduduk\PendudukPaginateAction;
use App\Actions\Sid\Penduduk\PendudukStoreAction;
use App\Actions\Sid\Penduduk\PendudukUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\SidPenduduk;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class PendudukController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidPenduduk::class, 'penduduk');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PendudukPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $penduduk = $index->execute($payload);

        if ($penduduk instanceof LengthAwarePaginator) {
            $penduduk->appends($request->query());
        }

        return Inertia::render('Dashboard/Sid/Penduduk/Index', compact('penduduk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Penduduk/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PendudukStoreAction $pendudukStoreAction)
    {
        /**
         * @var SidPenduduk
         */
        $penduduk = $pendudukStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.sid.penduduk.show', $penduduk->getKey()), 201)

            ->banner(sprintf('Penduduk Created', $penduduk->nama));
    }

    /**
     * Display the specified resource.
     */
    public function show(SidPenduduk $penduduk)
    {
        return Inertia::render('Dashboard/Sid/Penduduk/Show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidPenduduk $penduduk)
    {
        return Inertia::render('Dashboard/Sid/Penduduk/Edit', compact('penduduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidPenduduk $penduduk, PendudukUpdateAction $pendudukUpdateAction)
    {
        $pendudukUpdateAction->prepare($penduduk)->execute($request->all());

        return Response::see(route('dashboard.sid.penduduk.show', $penduduk->getKey()))

            ->banner(sprintf('Updated penduduk "%s"', $penduduk->nama));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidPenduduk $penduduk, PendudukDeleteAction $pendudukDeleteAction)
    {
        $pendudukDeleteAction->prepare($penduduk)->execute();

        return Response::see(route('dashboard.sid.penduduk.index'))

            ->with('flash', compact('penduduk'))
            ->dangerBanner(sprintf('Destroyed penduduk "%s"', $penduduk->name));
    }
}
