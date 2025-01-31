<?php

namespace App\Http\Controllers\api;

use App\Models\Karton;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\KartonResource;

class KartonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use CanLoadRelationships;
    private array $relations = ['pregleds','ustanova','zaposlenjes'];
    public function index()
    {
        Gate::authorize('viewAny',Karton::class);
        $query = $this->loadRelationships(Karton::query());
        return KartonResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create',Karton::class);
        $validatedData = $request->validate([
            'brojKnjizice' => 'required|string|unique:kartons',
            'napomene' => 'string|max:255',
            'ustanova_id' => 'required|integer|exists:ustanovas,id',
            'pacijent_jmbg' => 'required|string|exists:pacijents,jmbg'
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
        Gate::authorize('view',$karton);
        return new KartonResource($this->loadRelationships($karton));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karton = Karton::findOrFail($id);
        Gate::authorize('update',$karton);
        $validatedData = $request->validate([
            'napomene' => 'string|max:255',
            'ustanova_id' => 'required|integer|exists:ustanovas,id'
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
        Gate::authorize('delete',$karton);
        $karton->delete();
        return response()->json('Karton uspesno obrisan');
    }
}
