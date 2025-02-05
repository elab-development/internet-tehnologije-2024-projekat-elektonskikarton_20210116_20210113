<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Pacijent;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\PacijentResource;

class PacijentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use CanLoadRelationships;
    private array $relations = ['user', 'karton', 'karton.pregled', 'karton.zaposlenje', 'mesto'];

    public function index()
    {
        if (Gate::allows('viewAny', Pacijent::class)) {
            $query = $this->loadRelationships(Pacijent::query());
            return PacijentResource::collection($query->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled pacijenta.'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Gate::authorize('create', Pacijent::class);
        // $validatedUser = $request->validate([
        //     'name' => 'required|string|max:20',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|string|min:8'
        // ]);

        // // Kreiranje User-a
        // $user = User::create([...$validatedUser,'role'=>'pacijent']);
        // dd($user->role);
        // // Validacija za Doktora
        // $validatedPacijent = $request->validate([
        //     'jmbg' => 'required|string|unique:pacijents,jmbg',
        //     'imePrezimeNZZ' => 'string|max:100',
        //     'datumRodjenja' => 'required|date',
        //     'ulicaBroj' => 'required|string',
        //     'telefon' => 'required|string',
        //     'pol' => 'required|in:muski,zenski',
        //     'bracniStatus' => 'required|in:u braku, nije u braku',
        //     'mesto_postanskiBroj' => 'required|integer|exists:mestos,postanskiBroj'
        // ]);

        // $pacijent = Pacijent::create([...$validatedPacijent,'user_id'=>$user->id]);
        // return new PacijentResource($this->loadRelationships($pacijent));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pacijent = Pacijent::where('jmbg', $id)->firstOrFail();
        if (Gate::allows('view', $pacijent)) {
            return new PacijentResource($this->loadRelationships($pacijent));
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled pacijenta.'], 403);
        }
    }

    public function showWithId(string $user_id)
    {
        $pacijent = Pacijent::where('user_id', $user_id)->firstOrFail();
        if (Gate::allows('view', $pacijent)) {
            return new PacijentResource($this->loadRelationships($pacijent));
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled pacijenta.'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pacijent = Pacijent::where('jmbg', $id)->firstOrFail();

        if (Gate::authorize('update', $pacijent)) {
            $validatedPacijent = $request->validate([
                'imePrezimeNZZ' => 'string|max:100',
                'ulicaBroj' => 'required|string',
                'telefon' => 'required|string',
                'bracniStatus' => 'required|in:u braku,nije u braku',
                'mesto_postanskiBroj' => 'required|integer|exists:mestos,postanskiBroj'
            ]);
            $pacijent->update($validatedPacijent);

            return new PacijentResource($this->loadRelationships($pacijent));
        } else {
            return response()->json(['message' => 'Pristup odbijen za azuriranje pacijenta.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pacijent = Pacijent::where('jmbg', $id)->firstOrFail();
        if (Gate::allows('delete', $pacijent)) {
            $pacijent->delete();
            return response()->json('Uspesno obrisan pacijent');
        } else {
            return response()->json(['message' => 'Pristup odbijen za brisanje pacijenta.'], 403);
        }
    }

    public function getPacijentCount(){
        $pacijentCount = Pacijent::count();
        return response()->json(['pacijent_count' => $pacijentCount]);
    }
}
