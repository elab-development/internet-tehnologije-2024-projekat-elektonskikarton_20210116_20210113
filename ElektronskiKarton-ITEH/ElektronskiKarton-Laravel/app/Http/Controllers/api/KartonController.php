<?php

namespace App\Http\Controllers\api;

use App\Models\Karton;
use App\Models\Pacijent;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\KartonResource;

class KartonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use CanLoadRelationships;
    private array $relations = ['pregleds', 'ustanova', 'zaposlenjes','pregleds.doktor','pregleds.terapija','pregleds.dijagnoza'];
    public function index(Request $request)
    {
        if (Gate::allows('viewAny', Karton::class)) {
            $bk = $request->input('brojKnjizice');

            $kartoni = Karton::query()
                ->when($bk, fn($query, $bk) => $query->withBrojKnjizice($bk));

            $query = $this->loadRelationships($kartoni);
            return KartonResource::collection($query->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled kartona.'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::authorize('create', Karton::class)) {
            $validatedData = $request->validate([
                'brojKnjizice' => 'required|string|unique:kartons',
                'napomene' => 'string|max:255',
                'ustanova_id' => 'required|integer|exists:ustanovas,id',
                'pacijent_jmbg' => 'required|string|exists:pacijents,jmbg'
            ]);
            $karton = Karton::create($validatedData);
            return new KartonResource($this->loadRelationships($karton));
        } else {
            return response()->json(['message' => 'Pristup odbijen za kreiranje kartona.'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $karton = Karton::findOrFail($id);
        if (Gate::allows('view', $karton)) {
            return new KartonResource($this->loadRelationships($karton));
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled kartona.'], 403);
        }
    }

    public function showWithId(string $id)
    {
        $pacijent = Pacijent::where('user_id', $id)->firstOrFail();
        $karton = Karton::where('pacijent_jmbg', $pacijent->jmbg)->firstOrFail();
        if (Gate::allows('view', $karton)) {
            return new KartonResource($this->loadRelationships($karton));
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled kartona.'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karton = Karton::findOrFail($id);
        if (Gate::allows('update', $karton)) {
            $validatedData = $request->validate([
                'napomene' => 'string|max:255',
                'ustanova_id' => 'required|integer|exists:ustanovas,id'
            ]);
            $karton->update($validatedData);
            return new KartonResource($this->loadRelationships($karton));
        } else {
            return response()->json(['message' => 'Pristup odbijen za azuriranje kartona.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karton = Karton::findOrFail($id);
        if (Gate::allows('delete', $karton)) {
            $karton->delete();
            return response()->json('Karton uspesno obrisan');
        }else{
            return response()->json(['message' => 'Pristup odbijen za brisanje kartona.'], 403);
        }
    }
}
