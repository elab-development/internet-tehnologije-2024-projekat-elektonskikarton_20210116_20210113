<?php

namespace App\Http\Controllers\api;

use App\Models\Zaposlenje;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Resource\ZaposlenjeResource;
use App\Trait\CanLoadRelationships;

class ZaposlenjeController extends Controller
{
    use CanLoadRelationships;
    private array $relations = ['preduzece', 'preduzece.mesto'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->loadRelationships(Zaposlenje::query());
        return ZaposlenjeResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'preduzece_registarskiBroj' => 'required|exists:preduzece,registarskiBroj',
            'karton_id' => 'required|exists:karton, id',
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
        return new ZaposlenjeResource($this->loadRelationships($zaposlenje));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $zaposlenje = Zaposlenje::where('redniBroj', $id)->firstOrFail();
        $validatedData = $request->validate([
            'preduzece_registarskiBroj' => 'required|exists:preduzece,registarskiBroj',
            'karton_id' => 'required|exists:karton, id',
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
        $zaposlenje->delete();

        return response()->json('Uspesno obrisano zaposlenje');
    }
}
