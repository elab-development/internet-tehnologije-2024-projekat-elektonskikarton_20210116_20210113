<?php

namespace App\Http\Controllers\api;

use App\Models\Terapija;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\TerapijaResource;

class TerapijaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Gate::allows('viewAny', Terapija::class)) {
            $naziv = $request->input('naziv');
            $query = Terapija::query()->when($naziv, fn($query, $naziv) => $query->withNaziv($naziv));

            return TerapijaResource::collection($query->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled terapija.'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::allows('create', Terapija::class)) {

            $terapija = Terapija::create(
                $request->validate([
                    'naziv' => 'required|string|max:255',
                    'opis' => 'required|string|max:255',
                    'trajanje' => 'required|integer|min:1'
                ])
            );

            return new TerapijaResource($terapija);
        } else {
            return response()->json(['message' => 'Pristup odbijen za kreiranje terapija.'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $terapija = Terapija::findOrFail($id);
        if (Gate::allows('view', $terapija)) {

            return new TerapijaResource($terapija);
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled terapija.'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $terapija = Terapija::findOrFail($id);
        if (Gate::allows('update', $terapija)) {

            $terapija->update(
                $request->validate(
                    [
                        'naziv' => 'required|string|max:255',
                        'opis' => 'required|string|max:255',
                        'trajanje' => 'required|integer'
                    ]
                )
            );

            return new TerapijaResource($terapija);
        } else {
            return response()->json(['message' => 'Pristup odbijen za azuriranje terpaije.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $terapija = Terapija::findOrFail($id);
        if (Gate::allows('delete', $terapija)) {

            $terapija->delete();
            return response()->json('Successfully deleted');
        } else {
            return response()->json(['message' => 'Pristup odbijen za brisanje terapija.'], 403);
        }
    }
}
