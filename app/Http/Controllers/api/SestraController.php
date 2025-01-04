<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Doktor;
use App\Models\Sestra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Resource\SestraResource;
use App\Trait\CanLoadRelationships;

class SestraController extends Controller
{
    use CanLoadRelationships;
    private array $relations = ['user'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sestre = Sestra::query();
        return SestraResource::collection($sestre->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        'role' => 'sestra', // Postavljanje role
    ]);



    $sestra = Sestra::create([
        'user_id' => $user->id
    ]);

    // Povratni odgovor
    return response()->json([
        'message' => 'Sestra je uspešno kreirana.',
        'user' => $user,
        'sestra' => $sestra,
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sestra = Sestra::findOrFail($id);
        return new SestraResource($sestra);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Pronađi doktora i povezanog korisnika
    $sestra = Sestra::findOrFail($id);
    $user = User::findOrFail($sestra->user_id);

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


    // Povratni odgovor
    return response()->json([
        'message' => 'Sestra je uspešno ažurirana.',
        'user' => $user,
        'sestra' => $sestra,
    ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $sestra = Sestra::findOrFail($id);
        $user = User::findOrFail($sestra->user_id);
        $sestra->delete();
        $user->delete();

        return response()->json('Sestra je uspesno obrisana');
    }
}
