<?php

namespace App\Http\Controllers\Dashboard\Sid;

use App\Actions\Sid\Bantuan\BantuanDeleteAction;
use App\Actions\Sid\Bantuan\BantuanPaginateAction;
use App\Actions\Sid\Bantuan\BantuanStoreAction;
use App\Actions\Sid\Bantuan\BantuanUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\SidBantuan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class BantuanController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidBantuan::class, 'bantuan');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BantuanPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $bantuan = $index->execute($payload);

        if ($bantuan instanceof LengthAwarePaginator) {
            $bantuan->appends($request->query());
        }

        return Inertia::render('Dashboard/Sid/Bantuan/Index', compact('bantuan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Bantuan/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, BantuanStoreAction $bantuanStoreAction)
    {
        /**
         * @var SidBantuan
         */
        $bantuan = $bantuanStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.sid.bantuan.show', $bantuan->getKey()), 201)

            ->banner(sprintf('Bantuan Created', $bantuan->nomor_kartu_bantuan));
    }

    /**
     * Display the specified resource.
     */
    public function show(SidBantuan $bantuan)
    {
        return Inertia::render('Dashboard/Sid/Bantuan/Show', compact('bantuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidBantuan $bantuan)
    {
        return Inertia::render('Dashboard/Sid/Bantuan/Edit', compact('bantuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidBantuan $bantuan, BantuanUpdateAction $bantuanUpdateAction)
    {
        $bantuanUpdateAction->prepare($bantuan)->execute($request->all());

        return Response::see(route('dashboard.sid.bantuan.show', $bantuan->getKey()))

            ->banner(sprintf('Updated bantuan "%s"', $bantuan->nomor_kartu_bantuan));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidBantuan $bantuan, BantuanDeleteAction $bantuanDeleteAction)
    {
        $bantuanDeleteAction->prepare($bantuan)->execute();

        return Response::see(route('dashboard.sid.bantuan.index'))

            ->with('flash', compact('bantuan'))
            ->dangerBanner(sprintf('Destroyed bantuan "%s"', $bantuan->nomor_kartu_bantuan));
    }
}
