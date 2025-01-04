<?php

namespace App\Http\Controllers\api;

use App\Models\Pregled;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use App\Http\Resources\Resource\PregledResource;

class PregledController extends Controller
{
    use CanLoadRelationships;
    private array $relations = ['doktor','sestra','terapija','dijagnoza'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->loadRelationships(Pregled::query());
        return PregledResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pregled = Pregled::where('redniBroj',$id)->firstOrFail();
        return new PregledResource($this->loadRelationships($pregled));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $pregled = Pregled::where('redniBroj',$id)->firstOrFail();
        // $validatedData = $request->validate([
        //     'datum' => 'required|date',
        //     'doktor_id' => 'required|exists:doktors, id',
        //     'sestra_id' => 'required|exists:sestras, id',
        //     'terapija_id' => 'required|exists:terapijas, id',
        //     'dijagnoza_id' => 'required|exists:dijagnozas, id',
        //     'karton_id' => 'required|exists:karton, id'
        // ]);
        // $pregled->update($validatedData);
        // return new PregledResource($this->loadRelationships($pregled));
        return response()->json('Unauthorized');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pregled = Pregled::where('redniBroj',$id)->firstOrFail();
        $pregled->delete();
    }
}
