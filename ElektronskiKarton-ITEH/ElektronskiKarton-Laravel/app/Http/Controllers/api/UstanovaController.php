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

    public function index()
    {

        $query = $this->loadRelationships(Ustanova::query());
        return UstanovaResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Ustanova::class);

        $ustanova = Ustanova::create($request->validate([
            'naziv' => 'required|string',
            'ulicaBroj' => 'required|string',
            'mesto_postanskiBroj' => 'required|integer|exists:mestos,postanskiBroj'
        ]));

        return new UstanovaResource($ustanova);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ustanova = Ustanova::findOrFail($id);
        Gate::authorize('view', $ustanova);

        return new UstanovaResource($this->loadRelationships($ustanova));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ustanova = Ustanova::findOrFail($id);
        Gate::authorize('update', $ustanova);
        $ustanova->update($request->validate([
            'naziv' => 'required|string',
            'ulicaBroj' => 'required|string',
            'mesto_postanskiBroj' => 'required|integer|exists:mestos,postanskiBroj'
        ]));

        return new UstanovaResource($this->loadRelationships($ustanova));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ustanova = Ustanova::findOrFail($id);
        Gate::authorize('delete', $ustanova);

        $ustanova->delete();

        return response()->json("Deleted successfully");
    }

    public function getUstanoveCount(){
        $ustanoveCount = Ustanova::count();
        return response()->json(['ustanove_count' => $ustanoveCount]);
    }
}
