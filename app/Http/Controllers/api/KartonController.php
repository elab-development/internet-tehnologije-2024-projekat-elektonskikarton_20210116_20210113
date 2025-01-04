<?php

namespace App\Http\Controllers\api;

use App\Models\Karton;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Resource\KartonResource;
use App\Trait\CanLoadRelationships;

class KartonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use CanLoadRelationships;
    private array $relations = ['pregled'];
    public function index()
    {
        $query = $this->loadRelationships(Karton::query());
        return KartonResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brojKnjizice' => 'required|string|unique',
            'napomene' => 'string|max:255',
            'ustanova_id' => 'required|integer|exist:ustanovas,id',
            'pacijent_jmbg' => 'required|string|exist:pacijents,jmbg'
        ]);
        $karton = Karton::create($validatedData);
        return new KartonResource($this->loadRelationships($karton));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $karton = Karton::findOrFail($id);
        return new KartonResource($this->loadRelationships($karton));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karton = Karton::findOrFail($id);
        $validatedData = $request->validate([
            'brojKnjizice' => 'required|string|unique:kartons, brojKnjizice, ' . $karton->id,
            'napomene' => 'string|max:255',
            'ustanova_id' => 'required|integer|exist:ustanovas,id',
            'pacijent_jmbg' => 'required|string|exist:pacijents,jmbg'
        ]);
        $karton->update($validatedData);
        return new KartonResource($this->loadRelationships($karton));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karton = Karton::findOrFail($id);
        $karton->delete();
        return response()->json('Karton uspesno obrisan');
    }
}
