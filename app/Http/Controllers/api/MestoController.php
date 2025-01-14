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
        if (Gate::allows('viewAny', Mesto::class)) {
            $naziv = $request->input('naziv');
            $posBr = $request->input('postanskiBroj');

            $mesta = Mesto::query()
                ->when($naziv, fn($query, $naziv) => $query->withNaziv($naziv))
                ->when($posBr, fn($query, $posBr) => $query->withPostanskiBroj($posBr));

            $query = $this->loadRelationships($mesta);
            return MestoResource::collection($query->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled mesta.'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::allows('create', Mesto::class)) {
            $validatedData = $request->validate([
                'postanskiBroj' => 'required|integer|unique:mestos,postanskiBroj|min:10000|max:99999',
                'naziv' => 'required|string'
            ]);
            $mesto = Mesto::create($validatedData);
            return new MestoResource($this->loadRelationships($mesto));
        } else {
            return response()->json(['message' => 'Pristup odbijen za kreiranje mesta.'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mesto = Mesto::where('postanskiBroj', $id)->firstOrFail();
        if (Gate::allows('view', $mesto)) {
            return new MestoResource($this->loadRelationships($mesto));
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled mesta.'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mesto = Mesto::where('postanskiBroj', $id)->firstOrFail();
        if (Gate::allows('update', $mesto)) {
            $validatedData = $request->validate([
                'postanskiBroj' => 'required|integer|min:10000|max:99999|unique:mestos,postanskiBroj,' . $mesto->postanskiBroj,
                'naziv' => 'required|string'
            ]);
            $mesto->update($validatedData);
            return new MestoResource($this->loadRelationships($mesto));
        } else {
            return response()->json(['message' => 'Pristup odbijen za azuriranje mesta.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mesto = Mesto::where('postanskiBroj', $id)->firstOrFail();
        if (Gate::allows('delete', $mesto)) {
            $mesto->delete();
            return response()->json('Mesto uspesno obrisano');
        } else {
            return response()->json(['message' => 'Pristup odbijen za brisanje mesta.'], 403);
        }
    }
}
