<?php

namespace App\Http\Controllers\api;

use App\Models\Terapija;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource\TerapijaResource;

class TerapijaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny',Terapija::class);

        $query = Terapija::query();
        return TerapijaResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create',Terapija::class);

        $terapija = Terapija::create(
            $request->validate([
                'naziv' => 'required|string|max:255'
            ])
        );

        return new TerapijaResource($terapija);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $terapija = Terapija::findOrFail($id);
        Gate::authorize('view',$terapija);

        return new TerapijaResource($terapija);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $terapija = Terapija::findOrFail($id);
        Gate::authorize('update',$terapija);

        $terapija->update(
            $request->validate(
                [
                    'naziv' => 'required|string|max:255',
                    'opis'=>'required|string|max:255',
                    'trajanje'=>'required|integer'
                ]
            )
        );

        return new TerapijaResource($terapija);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $terapija = Terapija::findOrFail($id);
        Gate::authorize('delete',$terapija);

        $terapija->delete();
        return response()->json('Successfully deleted');
    }
}
