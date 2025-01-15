<?php

namespace App\Http\Controllers\api;

use App\Models\Preduzece;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\PreduzeceResource;

class PreduzeceController extends Controller
{

    use CanLoadRelationships;
    private array $relations = ['mesto'];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Gate::allows('viewAny', Preduzece::class)) {
            $regBroj = $request->input('registarskiBroj');
            $naziv = $request->input('naziv');
            $sifDel = $request->input('sifraDelatnosti');

            $preduzece = Preduzece::query()
                ->when($regBroj, fn($query, $regBroj) => $query->withRegistarskiBroj($regBroj))
                ->when($naziv, fn($query, $naziv) => $query->withNaziv($naziv))
                ->when($sifDel, fn($query, $sifDel) => $query->withSifraDelatnosti($sifDel));


            $query = $this->loadRelationships($preduzece);
            return PreduzeceResource::collection($query->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled preduzeca.'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::allows('create', Preduzece::class)) {

            $validatedData = $request->validate([
                'registarskiBroj' => 'required|integer|min:10000|max:99999|unique:preduzeces,registarskiBroj',
                'naziv' => 'required|string|max:255',
                'sifraDelatnosti' => 'required|integer|min:1|max:70',
                'mesto_postanskiBroj' => 'required|exists:mestos,postanskiBroj'
            ]);

            $preduzece = Preduzece::create($validatedData);

            return new PreduzeceResource($this->loadRelationships($preduzece));
        } else {
            return response()->json(['message' => 'Pristup odbijen za kreiranje preduzeca.'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $preduzece = Preduzece::where('registarskiBroj', $id)->firstOrFail();
        if (Gate::allows('view', $preduzece)) {
            return new PreduzeceResource($this->loadRelationships($preduzece));
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled preduzeca.'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $preduzece = Preduzece::where('registarskiBroj', $id)->firstOrFail();
        if (Gate::allows('update', $preduzece)) {

            $validatedData = $request->validate([
                'naziv' => 'required|string|max:255',
                'sifraDelatnosti' => 'required|integer|min:1|max:70',
                'mesto_postanskiBroj' => 'required|exists:mestos,postanskiBroj'
            ]);

            $preduzece->update($validatedData);

            return new PreduzeceResource($this->loadRelationships($preduzece));
        } else {
            return response()->json(['message' => 'Pristup odbijen za azuriranje preduzeca.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $preduzece = Preduzece::where('registarskiBroj', $id)->firstOrFail();
        if (Gate::allows('delete', $preduzece)) {

            $preduzece->delete();

            return response()->json('Uspesno obrisano preduzece');
        } else {
            return response()->json(['message' => 'Pristup odbijen za brisanje preduzeca.'], 403);
        }
    }
}
