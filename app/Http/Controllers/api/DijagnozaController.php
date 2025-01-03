<?php

namespace App\Http\Controllers\api;

use App\Models\Dijagnoza;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Resource\DijagnozaResource;

class DijagnozaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Dijagnoza::query();
        return DijagnozaResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dijagnoza = Dijagnoza::create(
            $request->validate([
                'naziv' => 'required|string|max:255'
            ])
        );

        return new DijagnozaResource($dijagnoza);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dijagnoza = Dijagnoza::findOrFail($id);
        return new DijagnozaResource($dijagnoza);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dijagnoza = Dijagnoza::findOrFail($id);
        $dijagnoza->update(
            $request->validate(
                [
                    'naziv' => 'required|string|max:255'
                ]
            )
        );

        return new DijagnozaResource($dijagnoza);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dijagnoza = Dijagnoza::findOrFail($id);
        $dijagnoza->delete();
        return response()->json('Successfully deleted');
    }
}
