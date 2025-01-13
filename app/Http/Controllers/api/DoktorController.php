<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Doktor;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\DoktorResource;
use App\Http\Resources\Resource\DijagnozaResource;

class DoktorController extends Controller
{
    use CanLoadRelationships;
    private $relations = ['user'];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Doktor::class);
        $spec = $request->input('specijalizacija');

        $doktori = Doktor::query()->when($spec, fn($query, $spec) => $query->withSpecijalizacija($spec));
        $query = $this->loadRelationships($doktori);

        return DijagnozaResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Doktor::class);

        // Validacija za User
        $validatedUser = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Kreiranje User-a
        $user = User::create([
            'name' => $validatedUser['name'],
            'email' => $validatedUser['email'],
            'password' => bcrypt($validatedUser['password']), // Šifriranje lozinke
            'role' => 'doktor', // Postavljanje role
        ]);

        // Validacija za Doktora
        $validatedDoktor = $request->validate([
            'specijalizacija' => 'required|string|max:20',
        ]);

        // Kreiranje Doktora
        $doktor = Doktor::create([
            'specijalizacija' => $validatedDoktor['specijalizacija'],
            'user_id' => $user->id,
        ]);

        // Povratni odgovor
        return response()->json([
            'message' => 'Doktor je uspešno kreiran.',
            'user' => $user,
            'doktor' => $doktor,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doktor = Doktor::findOrFail($id);
        return new DoktorResource($doktor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Pronađi doktora i povezanog korisnika
        $doktor = Doktor::findOrFail($id);
        $user = User::findOrFail($doktor->user_id);
        Gate::authorize('update', $doktor);

        // Validacija za User-a
        $validatedUser = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id, // Ignoriši trenutni korisnik
            'password' => 'nullable|string|min:8', // Lozinka nije obavezna prilikom ažuriranja
        ]);

        // Ažuriranje User-a
        $user->update([
            'name' => $validatedUser['name'],
            'email' => $validatedUser['email'],
            'password' => $validatedUser['password'] ? bcrypt($validatedUser['password']) : $user->password, // Ako nema nove lozinke, zadrži staru
        ]);

        // Validacija za Doktora
        $validatedDoktor = $request->validate([
            'specijalizacija' => 'required|string|max:20',
        ]);

        // Ažuriranje Doktora
        $doktor->update([
            'specijalizacija' => $validatedDoktor['specijalizacija'],
        ]);

        // Povratni odgovor
        return response()->json([
            'message' => 'Doktor je uspešno ažuriran.',
            'user' => $user,
            'doktor' => $doktor,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doktor = Doktor::findOrFail($id);
        Gate::authorize('delete', $doktor);

        $user = User::findOrFail($doktor->user_id);
        $doktor->delete();
        $user->delete();

        return response()->json('Doktor je uspesno obrisan');
    }
}
