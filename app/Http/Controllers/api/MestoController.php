<?php

namespace App\Http\Controllers\api;

use App\Models\Mesto;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\MestoResource;

class MestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use CanLoadRelationships;
    private array $relations = ['ustanova'];
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Mesto::class);
        $naziv=$request->input('naziv');
        $posBr=$request->input('postanskiBroj');

        $mesta=Mesto::query()
        ->when($naziv, fn($query, $naziv)=>$query->withNaziv($naziv))
        ->when($posBr, fn($query, $posBr)=>$query->withPostanskiBroj($posBr));

        $query = $this->loadRelationships($mesta);
        return MestoResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Mesto::class);
        $validatedData = $request->validate([
            'postanskiBroj' => 'required|integer|unique:mestos,postanskiBroj|min:10000|max:99999',
            'naziv' => 'required|string'
        ]);
        $mesto = Mesto::create($validatedData);
        return new MestoResource($this->loadRelationships($mesto));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mesto = Mesto::where('postanskiBroj', $id)->firstOrFail();
        Gate::authorize('view', $mesto);
        return new MestoResource($this->loadRelationships($mesto));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mesto = Mesto::where('postanskiBroj', $id)->firstOrFail();
        Gate::authorize('update', $mesto);
        $validatedData = $request->validate([
            'postanskiBroj' => 'required|integer|min:10000|max:99999|unique:mestos,postanskiBroj,' . $mesto->postanskiBroj,
            'naziv' => 'required|string'
        ]);
        $mesto->update($validatedData);
        return new MestoResource($this->loadRelationships($mesto));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mesto = Mesto::where('postanskiBroj', $id)->firstOrFail();
        Gate::authorize('delete', $mesto);
        $mesto->delete();
        return response()->json('Mesto uspesno obrisano');
    }
}
