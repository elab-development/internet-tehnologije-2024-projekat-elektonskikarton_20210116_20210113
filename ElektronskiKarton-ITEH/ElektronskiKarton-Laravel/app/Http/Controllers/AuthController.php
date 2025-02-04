<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pacijent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Resource\PacijentResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'name' => $user->name,
            'role' => $user->role,
            'email' => $user->email,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }


    public function register(Request $request){
        $validatedUser = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8'
        ]);
        $user = User::create([...$validatedUser,'role'=>'pacijent']);
        $validatedPacijent = $request->validate([
            'jmbg' => 'required|string|unique:pacijents,jmbg',
            'imePrezimeNZZ' => 'string|max:100',
            'datumRodjenja' => 'required|date',
            'ulicaBroj' => 'required|string',
            'telefon' => 'required|string',
            'pol' => 'required|in:muski,zenski',
            'bracniStatus' => 'required|in:u braku,nije u braku',
            'mesto_postanskiBroj' => 'required|integer|exists:mestos,postanskiBroj'
        ]);
        $pacijent = Pacijent::create([...$validatedPacijent,'user_id'=>$user->id]);
        return new PacijentResource($pacijent);
    }
}
