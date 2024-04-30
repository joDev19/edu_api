<?php

namespace App\Http\Controllers;

use App\Models\Epreuve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
class EpreuveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $epreuves = Epreuve::all();
            return response()->json([
                "success" => true,
                "data" => $epreuves,
                "message" => "Listes of epreuves"
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
            'intitule' => ['required'],
            'niveau_de_difficulte_id' => ['required', 'exists:niveau_de_difficultes,id'],
            'classe_id' => ['required', 'exists:classes,id'],
            'matiere_id' => ['required', 'exists:matieres,id'],
            'duree' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            $epreuve = Epreuve::create($validator->validated());
            return response()->json([
                "success" => true,
                "data" => $epreuve,
                "message" => "epreuve created"
            ], 200);
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
    public function show(int $epreuve)
    {
        if(!Epreuve::find($epreuve)){
            return response()->json([
                "success" => false,
                "reason" => "Epreuve not found",
            ], 404);
        }
        // try{
            $ep = Epreuve::find($epreuve);
            return response()->json([
                'success' => true,
                'message' => "Epreuve found",
                'data' => $ep
            ], 200);
        // }catch(Exception $e){
        //     return response()->json([
        //         'success' => false,
        //         'reason' => 'Error: '.$e->getMessage()
        //     ], 500);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $epreuve)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $epreuve)
    {
        $validator = Validator::make($request->all(), [
            'name' => [''],
            'description' => [''],
            'duree' => [''],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            if(!Epreuve::find($epreuve)){
                return response()->json([
                    'success' => false,
                    'reason' => "Epreuve not found"
                ], 404);
            }
            Epreuve::find($epreuve)->update($validator->validated());
                return response()->json([
                    'success' => true,
                    'message' => "Epreuve updated with success",
                    'data' => Epreuve::find($epreuve)
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
    public function destroy(int $epreuve)
    {
        try{
            if(!Epreuve::find($epreuve)){
                return response()->json([
                    'success' => false,
                    'reason' => "Epreuve not found"
                ], 404);
            }
            Epreuve::find($epreuve)->delete();
                return response()->json([
                    'success' => true,
                    'message' => "Epreuve deleted with success",
                    'data' => null
                ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'reason' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }

    public function questions($id){
        try{
            if(!Epreuve::find($id)){
                return response()->json([
                    'success' => false,
                    'reason' => "Epreuve not found"
                ], 404);
            }
            $data = Epreuve::find($id)->_questions();
            return response()->json([
                'success' => true,
                'message' => "List of questions of this epreuve",
                'data' => $data
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'reason' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }
}
