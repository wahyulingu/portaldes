<?php

namespace App\Http\Controllers\Dashboard\Sid;

use App\Actions\Sid\Pamong\PamongDeleteAction;
use App\Actions\Sid\Pamong\PamongPaginateAction;
use App\Actions\Sid\Pamong\PamongStoreAction;
use App\Actions\Sid\Pamong\PamongUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\Pamong\SidPamong;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class PamongController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidPamong::class, 'pamong');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PamongPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $pamong = $index->execute($payload);

        if ($pamong instanceof LengthAwarePaginator) {
            $pamong->appends($request->query());
        }

        return Inertia::render('Dashboard/Sid/Pamong/Index', compact('pamong'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Pamong/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PamongStoreAction $pamongStoreAction)
    {
        /**
         * @var SidPamong
         */
        $pamong = $pamongStoreAction->execute($request->all());

        return Response::redirectTo(route('dashboard.sid.pamong.show', $pamong->getKey()), 201)

            ->banner(sprintf('Pamong Created', $pamong->nama));
    }

    /**
     * Display the specified resource.
     */
    public function show(SidPamong $pamong)
    {
        return Inertia::render('Dashboard/Sid/Pamong/Show', compact('pamong'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidPamong $pamong)
    {
        return Inertia::render('Dashboard/Sid/Pamong/Edit', compact('pamong'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidPamong $pamong, PamongUpdateAction $pamongUpdateAction)
    {
        $pamongUpdateAction->prepare($pamong)->execute($request->all());

        return Response::see(route('dashboard.sid.pamong.show', $pamong->getKey()))

            ->banner(sprintf('Updated pamong "%s"', $pamong->nama));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidPamong $pamong, PamongDeleteAction $pamongDeleteAction)
    {
        $pamongDeleteAction->prepare($pamong)->execute();

        return Response::see(route('dashboard.sid.pamong.index'))

            ->with('flash', compact('pamong'))
            ->dangerBanner(sprintf('Destroyed pamong "%s"', $pamong->nama));
    }
}
