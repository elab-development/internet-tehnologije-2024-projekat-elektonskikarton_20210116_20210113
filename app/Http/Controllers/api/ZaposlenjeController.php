<?php

namespace App\Http\Controllers\api;

use App\Models\Zaposlenje;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\ZaposlenjeResource;

class ZaposlenjeController extends Controller
{
    use CanLoadRelationships;
    private array $relations = ['preduzece', 'preduzece.mesto'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny',Zaposlenje::class);
        $query = $this->loadRelationships(Zaposlenje::query());
        return ZaposlenjeResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Zaposlenje::class);
        $validatedData = $request->validate([
            'preduzece_registarskiBroj' => 'required|exists:preduzeces,registarskiBroj',
            'karton_id' => 'required|exists:kartons, id',
            'posao' => 'string|required'
        ]);

        $zaposlenje = Zaposlenje::create($validatedData);
        return new ZaposlenjeResource($this->loadRelationships($zaposlenje));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $zaposlenje = Zaposlenje::where('redniBroj', $id)->firstOrFail();
        Gate::authorize('view', $zaposlenje);
        return new ZaposlenjeResource($this->loadRelationships($zaposlenje));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $zaposlenje = Zaposlenje::where('redniBroj', $id)->firstOrFail();
        Gate::authorize('update', $zaposlenje);
        $validatedData = $request->validate([
            'preduzece_registarskiBroj' => 'required|exists:preduzeces,registarskiBroj',
            'karton_id' => 'required|exists:kartons, id',
            'posao' => 'string|required'
        ]);

        $zaposlenje->update($validatedData);
        return new ZaposlenjeResource($this->loadRelationships($zaposlenje));

        return response()->json('Uspesno azurirano zaposlenje');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $zaposlenje = Zaposlenje::where('redniBroj', $id)->firstOrFail();
        Gate::authorize('delete', $zaposlenje);
        $zaposlenje->delete();

        return response()->json('Uspesno obrisano zaposlenje');
    }
}
