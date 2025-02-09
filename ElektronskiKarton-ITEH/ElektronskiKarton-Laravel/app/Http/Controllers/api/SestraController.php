<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Doktor;
use App\Models\Sestra;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\SestraResource;

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
        if (Gate::allows('viewAny', Sestra::class)) {
            return SestraResource::collection($sestre->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled sestara.'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (Gate::allows('create', Sestra::class)) {

            $validatedUser = $request->validate([
                'name' => 'required|string|max:20',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $validatedUser['name'],
                'email' => $validatedUser['email'],
                'password' => bcrypt($validatedUser['password']), 
                'role' => 'sestra', 
            ]);

            $sestra = Sestra::create([
                'user_id' => $user->id
            ]);

            return response()->json([
                'message' => 'Sestra je uspešno kreirana.',
                'user' => $user,
                'sestra' => $sestra,
            ], 201);
        } else {
            return response()->json(['message' => 'Pristup odbijen za kreiranje sestara.'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sestra = Sestra::findOrFail($id);
        if (Gate::allows('view', $sestra)) {
            return new SestraResource($sestra);
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled sestara.'], 403);
        }
    }

    public function showWithId(string $user_id)
    {
        $sestra = Sestra::where('user_id', $user_id)->firstOrFail();
        if (Gate::allows('view', $sestra)) {
            return new SestraResource($sestra);
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled sestara.'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $sestra = Sestra::findOrFail($id);
        $user = User::findOrFail($sestra->user_id);
        if (Gate::allows('update', $sestra)) {

            $validatedUser = $request->validate([
                'name' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8',
            ]);


            $user->update([
                'name' => $validatedUser['name'],
                'email' => $validatedUser['email'],
                'password' => $validatedUser['password'] ? bcrypt($validatedUser['password']) : $user->password,
            ]);



            return response()->json([
                'message' => 'Sestra je uspešno ažurirana.',
                'user' => $user,
                'sestra' => $sestra,
            ], 200);
        } else {
            return response()->json(['message' => 'Pristup odbijen za azuriranje sestre.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sestra = Sestra::findOrFail($id);
        if (Gate::allows('delete', $sestra)) {
            $user = User::findOrFail($sestra->user_id);
            $sestra->delete();
            $user->delete();

            return response()->json('Sestra je uspesno obrisana');
        } else {
            return response()->json(['message' => 'Pristup odbijen za brisanje sestara.'], 403);
        }
    }
}
