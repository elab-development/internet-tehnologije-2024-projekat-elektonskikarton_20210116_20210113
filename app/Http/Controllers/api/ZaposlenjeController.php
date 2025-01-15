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
        if (Gate::allows('viewAny', Zaposlenje::class)) {
            $query = $this->loadRelationships(Zaposlenje::query());
            return ZaposlenjeResource::collection($query->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled zaposlenja.'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::allows('create', Zaposlenje::class)) {
            $validatedData = $request->validate([
                'preduzece_registarskiBroj' => 'required|exists:preduzeces,registarskiBroj',
                'karton_id' => 'required|exists:kartons,id',
                'posao' => 'string|required'
            ]);

            $zaposlenje = Zaposlenje::create($validatedData);
            return new ZaposlenjeResource($this->loadRelationships($zaposlenje));
        } else {
            return response()->json(['message' => 'Pristup odbijen za kreiranje zaposlenja.'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $zaposlenje = Zaposlenje::where('redniBroj', $id)->firstOrFail();
        if (Gate::allows('view', $zaposlenje)) {
            return new ZaposlenjeResource($this->loadRelationships($zaposlenje));
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled zaposlenja.'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $redniBroj, int $karton_id)
    {

        $zaposlenje = Zaposlenje::where('redniBroj', $redniBroj)
            ->where('karton_id', $karton_id)
            ->firstOrFail();
      

        if (Gate::allows('update', $zaposlenje)) {
            $validatedData = $request->validate([
                'preduzece_registarskiBroj' => 'required|exists:preduzeces,registarskiBroj',
                'posao' => 'string|required'
            ]);
         
            $zaposlenje->update($validatedData);
             
            return new ZaposlenjeResource($this->loadRelationships($zaposlenje));

            return response()->json('Uspesno azurirano zaposlenje');
        } else {
            return response()->json(['message' => 'Pristup odbijen za azuriranje zaposlenja.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $zaposlenje = Zaposlenje::where('redniBroj', $id)->firstOrFail();
        if (Gate::allows('delete', $zaposlenje)) {
            $zaposlenje->delete();

            return response()->json('Uspesno obrisano zaposlenje');
        } else {
            return response()->json(['message' => 'Pristup odbijen za brisanje zaposlenja.'], 403);
        }
    }
}
