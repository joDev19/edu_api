<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Universite;
use Illuminate\Http\Request;

class UniversiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' =>  Universite::all(),
            'message' => 'Liste des universites'
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
        $universite = Universite::create($validator->validated());
        return response()->json([
            'success' => true,
            'data' =>  $universite,
            'message' => 'Créer avec succès'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Universite $universite)
    {
        return response()->json([
            'success' => true,
            'data' =>  $universite,
            'message' => 'Trouvé avec succès'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Universite $universite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Universite $universite)
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
        $universite->update($validator->validated());
        return response()->json([
            'success' => true,
            'data' =>  $universite,
            'message' => 'Modifié avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Universite $universite)
    {
        $universite->delete();
        return response()->json([
            'success' => true,
            'data' =>  null,
            'message' => 'Suprrimé avec succès'
        ]);
    }
}
