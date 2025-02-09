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
        if (Gate::allows('viewAny', Doktor::class)) {
            $spec = $request->input('specijalizacija');

            $doktori = Doktor::query()->when($spec, fn($query, $spec) => $query->withSpecijalizacija($spec));
            $query = $this->loadRelationships($doktori);

            return DijagnozaResource::collection($query->latest()->paginate());
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled doktora.'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::authorize('create', Doktor::class)) {

            $validatedUser = $request->validate([
                'name' => 'required|string|max:20',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);


            $user = User::create([
                'name' => $validatedUser['name'],
                'email' => $validatedUser['email'],
                'password' => bcrypt($validatedUser['password']), // Šifriranje lozinke
                'role' => 'doktor', // Postavljanje role
            ]);


            $validatedDoktor = $request->validate([
                'specijalizacija' => 'required|string|max:20',
            ]);

            $doktor = Doktor::create([
                'specijalizacija' => $validatedDoktor['specijalizacija'],
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => 'Doktor je uspešno kreiran.',
                'user' => $user,
                'doktor' => $doktor,
            ], 201);
        } else {
            return response()->json(['message' => 'Pristup odbijen za kreiranje doktora.'], 403);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doktor = Doktor::findOrFail($id);
        if (Gate::allows('view', $doktor)) {
            return new DoktorResource($this->loadRelationships($doktor));
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled doktora.'], 403);
        }
    }

    public function showWithId(string $user_id)
    {
        $doktor = Doktor::where('user_id', $user_id)->firstOrFail();
        if (Gate::allows('view', $doktor)) {
            return new DoktorResource($doktor);
        } else {
            return response()->json(['message' => 'Pristup odbijen za pregled doktora.'], 403);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $doktor = Doktor::findOrFail($id);
        $user = User::findOrFail($doktor->user_id);
        if (Gate::allows('update', $doktor)) {

            $validatedUser = $request->validate([
                'name' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8'
            ]);


            $user->update([
                'name' => $validatedUser['name'],
                'email' => $validatedUser['email'],
                'password' => $validatedUser['password'] ? bcrypt($validatedUser['password']) : $user->password,
            ]);

            $validatedDoktor = $request->validate([
                'specijalizacija' => 'required|string|max:20',
            ]);

            $doktor->update([
                'specijalizacija' => $validatedDoktor['specijalizacija'],
            ]);

            return response()->json([
                'message' => 'Doktor je uspešno ažuriran.',
                'user' => $user,
                'doktor' => $doktor,
            ], 200);
        } else {
            return response()->json(['message' => 'Pristup odbijen za azuriranje doktora.'], 403);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doktor = Doktor::findOrFail($id);
        if (Gate::allows('delete', $doktor)) {

            $user = User::findOrFail($doktor->user_id);
            $doktor->delete();
            $user->delete();

            return response()->json('Doktor je uspesno obrisan');
        }else{
            return response()->json(['message' => 'Pristup odbijen za brisanje doktora.'], 403);
        }
    }

    public function getDoktorCount(){
        $doctorCount = Doktor::count();
        return response()->json(['doktor_count' => $doctorCount]);
    }
}
