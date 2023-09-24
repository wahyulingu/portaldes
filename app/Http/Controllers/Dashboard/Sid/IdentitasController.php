<?php

namespace App\Http\Controllers\Dashboard\Sid;

use App\Actions\Sid\Identitas\IdentitasFetchAction;
use App\Actions\Sid\Identitas\IdentitasUpdateAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class IdentitasController extends Controller
{
    /**
     * Display the resource.
     */
    public function show(IdentitasFetchAction $identitasUpdateAction)
    {
        $this->authorize('view.sid.identitas');

        $identitas = $identitasUpdateAction->execute();

        return Inertia::render('Dashboard/Sid/Identitas/Show', compact('identitas'));
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit(IdentitasFetchAction $identitasUpdateAction)
    {
        $this->authorize('update.sid.identitas');

        $identitas = $identitasUpdateAction->execute();

        return Inertia::render('Dashboard/Sid/Identitas/Edit', compact('identitas'));
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request, IdentitasUpdateAction $identitasUpdateAction)
    {
        $this->authorize('update.sid.identitas');

        $identitasUpdateAction->execute($request->all());

        return Response::see(route('dashboard.sid.identitas.show'))

            ->banner(sprintf('Updated identitas'));
    }
}
