<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $matieres = Matiere::all();
            return response()->json([
                "success" => true,
                "data" => $matieres,
                "message" => "Listes of matieres"
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
            'name' => ['required'],
            'description' => [''],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            $matiere = Matiere::create($validator->validated());
            return response()->json([
                "success" => true,
                "data" => $matiere,
                "message" => "matiere created"
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
    public function show(int $matiere)
    {
        if(!Matiere::find($matiere)){
            return response()->json([
                "success" => false,
                "reason" => "Matiere not found",
            ], 404);
        }
        try{
            $mat = Matiere::find($matiere);
            return response()->json([
                'success' => true,
                'message' => "Matiere found",
                'data' => $mat
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
    public function edit(Matiere $matiere)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $matiere)
    {
        $validator = Validator::make($request->all(), [
            'name' => [''],
            'description' => [''],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            if(!Matiere::find($matiere)){
                return response()->json([
                    'success' => false,
                    'reason' => "Matiere not found"
                ], 404);
            }
            Matiere::find($matiere)->update($validator->validated());
                return response()->json([
                    'success' => true,
                    'message' => "Matiere updated with success",
                    'data' => Matiere::find($matiere)
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
    public function destroy(int $matiere)
    {
        try{
            if(!Matiere::find($matiere)){
                return response()->json([
                    'success' => false,
                    'reason' => "Matiere not found"
                ], 404);
            }
            Matiere::find($matiere)->delete();
                return response()->json([
                    'success' => true,
                    'message' => "Matiere deleted with success",
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
