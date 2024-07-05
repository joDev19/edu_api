<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' =>  Filiere::all(),
            'message' => 'Liste des filiere'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        $filiere = Filiere::create($validator->validated());
        return response()->json([
            'success' => true,
            'data' =>  $filiere,
            'message' => 'Créer avec succès'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Filiere $filiere)
    {
        return response()->json([
            'success' => true,
            'data' =>  $filiere,
            'message' => 'Trouvé avec succès'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Filiere $filiere)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filiere $filiere)
    {
        $validator = Validator::make($request->all(), [
            'nom' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        $filiere->update($validator->validated());
        return response()->json([
            'success' => true,
            'data' =>  $filiere,
            'message' => 'Modifié avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filiere $filiere)
    {
        $filiere->delete();
        return response()->json([
            'success' => true,
            'data' =>  null,
            'message' => 'Suprrimé avec succès'
        ]);
    }
}
