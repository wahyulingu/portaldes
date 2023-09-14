<?php

namespace App\Http\Controllers\Dashboard\Sid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class IdentitasController extends Controller
{
    /**
     * Display the resource.
     */
    public function show()
    {
        $this->authorize('view.sid.identitas');

        $identitas = [];

        return Inertia::render('Dashboard/Sid/Identitas/Show', compact('identitas'));
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        $this->authorize('update.sid.identitas');

        $identitas = [];

        return Inertia::render('Dashboard/Sid/Identitas/Edit', compact('identitas'));
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request)
    {
        $this->authorize('update.sid.identitas');

        return Response::see(route('dashboard.sid.identitas.show'))

            ->banner(sprintf('Updated identitas'));
    }
}
