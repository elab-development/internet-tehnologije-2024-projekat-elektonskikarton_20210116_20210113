<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Doktor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Resource\DoktorResource;
use App\Http\Resources\Resource\DijagnozaResource;

class DoktorController extends Controller
{
    private $relations = ['user'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doktori = Doktor::query();
        return DijagnozaResource::collection($doktori->latest()->paginate());
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
        $user = User::findOrFail($doktor->user_id);
        $doktor->delete();
        $user->delete();

        return response()->json('Doktor je uspesno obrisan');

    }
}
