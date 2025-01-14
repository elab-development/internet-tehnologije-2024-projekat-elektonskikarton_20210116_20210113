<?php

namespace App\Http\Controllers\api;

use App\Models\Ustanova;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\UstanovaResource;

class UstanovaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use CanLoadRelationships;
    private array $relations = ['mesto'];

    public function index(Request $request)
    {
        if (Gate::allows('viewAny', Ustanova::class)) {
            $naziv = $request->input('naziv');
            $posBroj = $request->input('postanskiBroj');

            $ustanove = Ustanova::query()
                ->when($naziv, fn($query, $naziv) => $query->withNaziv($naziv))
                ->when($posBroj, fn($query, $posBroj) => $query->withMesto($posBroj));

            $query = $this->loadRelationships($ustanove);
            return UstanovaResource::collection($query->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled ustanova.'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::allows('create', Ustanova::class)) {

            $ustanova = Ustanova::create($request->validate([
                'naziv' => 'required|string',
                'ulicaBroj' => 'required|string',
                'mesto_postanskiBroj' => 'required|integer|exists:mestos,postanskiBroj'
            ]));

            return new UstanovaResource($ustanova);
        } else {
            return response()->json(['message' => 'Pristup odbijen za kreiranje ustanova.'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ustanova = Ustanova::findOrFail($id);
        if (Gate::allows('view', $ustanova)) {
            return new UstanovaResource($this->loadRelationships($ustanova));
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled ustanove.'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ustanova = Ustanova::findOrFail($id);
        if (Gate::allows('update', $ustanova)) {
            $ustanova->update($request->validate([
                'naziv' => 'required|string',
                'ulicaBroj' => 'required|string',
                'mesto_postanskiBroj' => 'required|integer|exists:mestos,postanskiBroj'
            ]));

            return new UstanovaResource($this->loadRelationships($ustanova));
        } else {
            return response()->json(['message' => 'Pristup odbijen za azuriranje ustanova.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ustanova = Ustanova::findOrFail($id);
        if (Gate::authorize('delete', $ustanova)) {

            $ustanova->delete();

            return response()->json("Uspesno obrisano");
        } else {
            return response()->json(['message' => 'Pristup odbijen za brisanje ustanova.'], 403);
        }
    }
}
