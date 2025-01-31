<?php

namespace App\Http\Controllers\api;

use App\Models\Zaposlenje;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\ZaposlenjeResource;
use Exception;

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
        $zaposlenje = Zaposlenje::where('karton_id', $id)->firstOrFail();
        if (Gate::allows('view', $zaposlenje)) {
            return new ZaposlenjeResource($this->loadRelationships($zaposlenje));
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled zaposlenja.'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, int $redniBroj, int $karton_id)
    public function update(Request $request)
    {


        // $zaposlenje = Zaposlenje::where('redniBroj', $redniBroj)
        //     ->where('karton_id', $karton_id)
        //     ->firstOrFail();

        // if (Gate::allows('update', $zaposlenje)) {

        //     $validatedData = $request->validate([
        //         'preduzece_registarskiBroj' => 'required|integer|exists:preduzeces,registarskiBroj',
        //         'posao' => 'required|string'
        //     ]);
        //     // dd($zaposlenje, $validatedData);

        //     //$zaposlenje->update($validatedData);
        //   //  dd($zaposlenje);

        //     $zaposlenje->preduzece_registarskiBroj=$validatedData['preduzece_registarskiBroj'];
        //     $zaposlenje->posao=$validatedData['posao'];
        //    // dd($zaposlenje);
        //     $zaposlenje->save();


        //     return new ZaposlenjeResource($this->loadRelationships($zaposlenje));

        //     return response()->json('Uspesno azurirano zaposlenje');
        // } else {
        //     return response()->json(['message' => 'Pristup odbijen za azuriranje zaposlenja.'], 403);
        // }
        return response()->json('Neomoguceno');
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
