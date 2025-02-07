<?php

namespace App\Http\Controllers\api;

use App\Models\Karton;
use App\Models\Pregled;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\PregledResource;

class PregledController extends Controller
{
    use CanLoadRelationships;
    private array $relations = ['doktor', 'sestra', 'terapija', 'dijagnoza', 'karton'];
    /**
     * Display a listing of the resource.
     */
   public function indexForKarton(int $karton_id)
    {
        $karton = Karton::findOrFail($karton_id);
        if (Gate::allows('viewForAnyPatient', $karton)) {
            $query = $this->loadRelationships(Pregled::where('karton_id', $karton_id));
            return PregledResource::collection($query->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled pregleda.'], 403);
        }
    }
 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::allows('create', Pregled::class)) {
            $validatedData = $request->validate([
                'datum' => 'required|date',
                'doktor_id' => 'required|exists:doktors, id',
                'sestra_id' => 'required|exists:sestras, id',
                'terapija_id' => 'required|exists:terapijas, id',
                'dijagnoza_id' => 'required|exists:dijagnozas, id',
                'karton_id' => 'required|exists:karton, id'
            ]);

            $pregled = Pregled::create($validatedData);
            return new PregledResource($this->loadRelationships($pregled));
        } else {
            return response()->json(['message' => 'Pristup odbijen za kreiranje pregleda.'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showForKarton(int $karton_id, int $rb)
    {
        $karton = Karton::findOrFail($karton_id);
        if (Gate::authorize('viewForAnyPatient', $karton)) {
            $query = $this->loadRelationships(Pregled::where('karton_id', $karton->id)->where('redniBroj', $rb));
            return new PregledResource($query->firstOrFail());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled pregleda.'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json('Unauthorized');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json('Unauthorized');
    }
}
