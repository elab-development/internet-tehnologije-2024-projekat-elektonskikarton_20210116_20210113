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
    private array $relations = ['user','karton', 'karton.pregled', 'karton.zaposlenje','mesto'];

    public function index()
    {
        Gate::authorize('viewAny',Pacijent::class);
        $query = $this->loadRelationships(Pacijent::query());
        return PacijentResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Pacijent::class);
        $validatedUser = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        // Kreiranje User-a
        $user = User::create([...$validatedUser,'role'=>'pacijent']);
        dd($user->role);
        // Validacija za Doktora
        $validatedPacijent = $request->validate([
            'jmbg' => 'required|string|unique:pacijents,jmbg',
            'imePrezimeNZZ' => 'string|max:100',
            'datumRodjenja' => 'required|date',
            'ulicaBroj' => 'required|string',
            'telefon' => 'required|string',
            'pol' => 'required|in:muski,zenski',
            'bracniStatus' => 'required|in:u braku, nije u braku',
            'mesto_postanskiBroj' => 'required|integer|exists:mestos,postanskiBroj'
        ]);

        $pacijent = Pacijent::create([...$validatedPacijent,'user_id'=>$user->id]);
        return new PacijentResource($this->loadRelationships($pacijent));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pacijent = Pacijent::where('jmbg', $id)->firstOrFail();
        Gate::authorize('view', $pacijent);
        return new PacijentResource($this->loadRelationships($pacijent));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pacijent = Pacijent::where('jmbg', $id)->firstOrFail();

        Gate::authorize('update', $pacijent);


        // Validacija za Doktora
        $validatedPacijent = $request->validate([
            'imePrezimeNZZ' => 'string|max:100',
            'ulicaBroj' => 'required|string',
            'telefon' => 'required|string',
            'bracniStatus' => 'required|in:u braku, nije u braku',
            'mesto_postanskiBroj' => 'required|integer|exists:mestos,postanskiBroj'
        ]);

        $pacijent->update($validatedPacijent);

        return new PacijentResource($this->loadRelationships($pacijent));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pacijent = Pacijent::where('jmbg', $id)->firstOrFail();
        Gate::auhtorize('delete', $pacijent);
        $pacijent->delete();

        return response()->json('Uspesno obrisan pacijent');
    }
}
