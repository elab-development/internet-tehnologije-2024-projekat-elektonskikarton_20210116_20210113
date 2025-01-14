<?php

namespace App\Http\Controllers\api;

use App\Models\Dijagnoza;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\DijagnozaResource;

class DijagnozaController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::allows('viewAny', Dijagnoza::class)) {
            $naziv = $request->input('naziv');
            $query = Dijagnoza::query()->when($naziv, fn($query, $naziv) => $query->withNaziv($naziv));
            return DijagnozaResource::collection($query->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled dijagnoza.'], 403);
        }
    }
    public function store(Request $request)
    {
        if (Gate::allows('create', Dijagnoza::class)) {
            $dijagnoza = Dijagnoza::create(
                $request->validate([
                    'naziv' => 'required|string|max:255'
                ])
            );

            return new DijagnozaResource($dijagnoza);
        } else {
            return response()->json(['message' => 'Pristup odbijen za kreiranje dijagnoze.'], 403);
        }
    }
    public function show(string $id)
    {
        $dijagnoza = Dijagnoza::findOrFail($id);
        if (Gate::allows('view', $dijagnoza)) {
            return new DijagnozaResource($dijagnoza);
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled dijagnoze.'], 403);
        }
    }
    public function update(Request $request, string $id)
    {
        $dijagnoza = Dijagnoza::findOrFail($id);
        if (Gate::allows('update', $dijagnoza)) {

            $dijagnoza->update(
                $request->validate(
                    [
                        'naziv' => 'required|string|max:255'
                    ]
                )
            );

            return new DijagnozaResource($dijagnoza);
        } else {
            return response()->json(['message' => 'Pristup odbijen za azuriranje dijagnoze.'], 403);
        }
    }
    public function destroy(string $id)
    {
        $dijagnoza = Dijagnoza::findOrFail($id);
        if (Gate::allows('delete', $dijagnoza)) {
            $dijagnoza->delete();
            return response()->json('Uspesno obrisano');
        }else {
            return response()->json(['message' => 'Pristup odbijen za brisanje dijagnoze.'], 403);
        }
    }
}
