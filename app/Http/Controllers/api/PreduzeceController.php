<?php

namespace App\Http\Controllers\api;

use App\Models\Preduzece;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use App\Http\Resources\Resource\PreduzeceResource;

class PreduzeceController extends Controller
{

    use CanLoadRelationships;
    private array $relations = ['mesto'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->loadRelationships(Preduzece::query());
        return PreduzeceResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'registarskiBroj' => 'required|integer|min:10000|max:99999|unique',
            'naziv' => 'required|string|max:255',
            'sifraDelatnosti' => 'required|integer|min:1|max:70',
            'mesto_postanskiBroj' => 'required|exists: mesto,postanskiBroj'
        ]);

        $preduzece = Preduzece::create($validatedData);
        return new PreduzeceResource($this->loadRelationships($preduzece));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $preduzece = Preduzece::where('registarskiBroj', $id)->firstOrFail();
        return new PreduzeceResource($this->loadRelationships($preduzece));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $preduzece = Preduzece::where('registarskiBroj', $id)->firstOrFail();
        $validatedData = $request->validate([
            'registarskiBroj' => 'required|integer|min:10000|max:99999|unique: preduzece, registarskiBroj,'.$preduzece->registarskiBroj,
            'naziv' => 'required|string|max:255',
            'sifraDelatnosti' => 'required|integer|min:1|max:70',
            'mesto_postanskiBroj' => 'required|exists: mesto,postanskiBroj'
        ]);

        $preduzece->update($validatedData);
        return new PreduzeceResource($this->loadRelationships($preduzece));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $preduzece = Preduzece::where('registarskiBroj', $id)->firstOrFail();
        $preduzece->delete();

        return response()->json('Uspesno obrisano preduze');
    }
}
