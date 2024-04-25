<?php

namespace App\Http\Controllers;

use App\Models\NiveauDeDifficulte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class NiveauDeDifficulteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $niveauDeDifficulte = NiveauDeDifficulte::all();
            return response()->json([
                "success" => true,
                "data" => $niveauDeDifficulte,
                "message" => "Listes of niveauDeDifficulte"
            ]);
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "reason" => 'Error: '.$e->getMessage(),
            ], 500);
        }
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
            'niveau' => ['required', 'numeric'],
            'description' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            $niveauDeDifficulte = NiveauDeDifficulte::create($validator->validated());
            return response()->json([
                "success" => true,
                "data" => $niveauDeDifficulte,
                "message" => "$niveauDeDifficulte created"
            ]);
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "reason" => 'Error: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $niveauDeDifficulte)
    {
        if(!NiveauDeDifficulte::find($niveauDeDifficulte)){
            return response()->json([
                "success" => false,
                "reason" => "NiveauDeDifficulte not found",
            ], 404);
        }
        try{
            $niv = NiveauDeDifficulte::find($niveauDeDifficulte);
            return response()->json([
                'success' => true,
                'message' => "NiveauDeDifficulte found",
                'data' => $niv
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'reason' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NiveauDeDifficulte $niveauDeDifficulte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $niveauDeDifficulte)
    {
        $validator = Validator::make($request->all(), [
            'niveau' => [''],
            'description' => [''],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            if(!NiveauDeDifficulte::find($niveauDeDifficulte)){
                return response()->json([
                    'success' => false,
                    'reason' => "NiveauDeDifficulte not found"
                ], 404);
            }
            NiveauDeDifficulte::find($niveauDeDifficulte)->update($validator->validated());
                return response()->json([
                    'success' => true,
                    'message' => "NiveauDeDifficulte updated with success",
                    'data' => NiveauDeDifficulte::find($niveauDeDifficulte)
                ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'reason' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $niveauDeDifficulte)
    {
        try{
            if(!NiveauDeDifficulte::find($niveauDeDifficulte)){
                return response()->json([
                    'success' => false,
                    'reason' => "NiveauDeDifficulte not found"
                ], 404);
            }
            NiveauDeDifficulte::find($niveauDeDifficulte)->delete();
                return response()->json([
                    'success' => true,
                    'message' => "NiveauDeDifficulte deleted with success",
                    'data' => null
                ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'reason' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }
}
