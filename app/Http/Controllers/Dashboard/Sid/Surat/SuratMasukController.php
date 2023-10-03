<?php

namespace App\Http\Controllers\Dashboard\Sid\Wilayah;

use App\Actions\Sid\Wilayah\RukunTetangga\RukunTetanggaDeleteAction;
use App\Actions\Sid\Wilayah\RukunTetangga\RukunTetanggaIndexAction;
use App\Actions\Sid\Wilayah\RukunTetangga\RukunTetanggaStoreAction;
use App\Actions\Sid\Wilayah\RukunTetangga\RukunTetanggaUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class RukunTetanggaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidWilayahRukunTetangga::class, 'rukun_tetangga');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, RukunTetanggaIndexAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $rukun_tetangga = $index->execute($payload);

        if ($rukun_tetangga instanceof LengthAwarePaginator) {
            $rukun_tetangga->appends($request->query());
        }

        return Inertia::render('Dashboard/Sid/Wilayah/RukunTetangga/Index', compact('rukun_tetangga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Wilayah/RukunTetangga/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, RukunTetanggaStoreAction $rukun_tetanggaStoreAction)
    {
        /**
         * @var SidWilayahRukunTetangga
         */
        $rukun_tetangga = $rukun_tetanggaStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.sid.wilayah.rukun-tetangga.show', $rukun_tetangga->getKey()), 201)

            ->banner(sprintf('RukunTetangga Created', $rukun_tetangga->nama));
    }

    /**
     * Display the specified resource.
     */
    public function show(SidWilayahRukunTetangga $rukun_tetangga)
    {
        return Inertia::render('Dashboard/Sid/Wilayah/RukunTetangga/Show', compact('rukun_tetangga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidWilayahRukunTetangga $rukun_tetangga)
    {
        return Inertia::render('Dashboard/Sid/Wilayah/RukunTetangga/Edit', compact('rukun_tetangga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidWilayahRukunTetangga $rukun_tetangga, RukunTetanggaUpdateAction $rukun_tetanggaUpdateAction)
    {
        $rukun_tetanggaUpdateAction->prepare($rukun_tetangga)->execute($request->all());

        return Response::see(route('dashboard.sid.wilayah.rukun-tetangga.show', $rukun_tetangga->getKey()))

            ->banner(sprintf('Updated RukunTetangga "%s"', $rukun_tetangga->nama));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidWilayahRukunTetangga $rukun_tetangga, RukunTetanggaDeleteAction $rukun_tetanggaDeleteAction)
    {
        $rukun_tetanggaDeleteAction->prepare($rukun_tetangga)->execute();

        return Response::see(route('dashboard.sid.wilayah.rukun-tetangga.index'))

            ->with('flash', compact('rukun_tetangga'))
            ->dangerBanner(sprintf('Destroyed RukunTetangga "%s"', $rukun_tetangga->nama));
    }
}
