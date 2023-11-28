<?php

namespace App\Http\Controllers\Dashboard\Sid\Surat;

use App\Actions\Sid\Surat\SuratDeleteAction;
use App\Actions\Sid\Surat\SuratPaginateAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\Surat\SidSurat;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class SuratController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SidSurat::class, 'surat');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, SuratPaginateAction $index)
    {
        $payload = ['limit' => $request->get('limit', 8)];

        if ($keyword = $request->get('keyword')) {
            $payload['keyword'] = $keyword;
        }

        $surat = $index->execute($payload);

        if ($surat instanceof LengthAwarePaginator) {
            $surat->appends($request->query());
        }

        return Inertia::render('Dashboard/Sid/Surat/Index', compact('surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Surat/Create');
    }

    /**
     * Display the specified resource.
     */
    public function show(SidSurat $surat)
    {
        return Inertia::render('Dashboard/Sid/Surat/Show', compact('surat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidSurat $surat)
    {
        return Inertia::render('Dashboard/Sid/Surat/Edit', compact('surat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidSurat $surat)
    {
        return Response::see(route('dashboard.sid.surat.show', $surat->getKey()))

            ->banner(sprintf('Updated Lingkungan "%s"', $surat->nama));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidSurat $surat, SuratDeleteAction $suratDeleteAction)
    {
        $suratDeleteAction->prepare($surat)->execute();

        return Response::see(route('dashboard.sid.surat.index'))

            ->with('flash', compact('surat'))
            ->dangerBanner(sprintf('Destroyed Surat "%s"', $surat->nama));
    }
}
