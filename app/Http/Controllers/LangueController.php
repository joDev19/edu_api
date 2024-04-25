<?php

namespace App\Http\Controllers;

use App\Models\Langue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class LangueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $langues = Langue::all();
            return response()->json([
                "success" => true,
                "data" => $langues,
                "message" => "Listes of langues"
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
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            $langue = Langue::create($validator->validated());
            return response()->json([
                "success" => true,
                "data" => $langue,
                "message" => "langue created"
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
    public function show(int $langue)
    {
        if(!Langue::find($langue)){
            return response()->json([
                "success" => false,
                "reason" => "Langue not found",
            ], 404);
        }
        try{
            $lan = Langue::find($langue);
            return response()->json([
                'success' => true,
                'message' => "Langue found",
                'data' => $lan
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
    public function edit(Langue $langue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $langue)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            if(!Langue::find($langue)){
                return response()->json([
                    'success' => false,
                    'reason' => "Langue not found"
                ], 404);
            }
            Langue::find($langue)->update($validator->validated());
                return response()->json([
                    'success' => true,
                    'message' => "Langue updated with success",
                    'data' => Langue::find($langue)
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
    public function destroy(int $langue)
    {
        try{
            if(!Langue::find($langue)){
                return response()->json([
                    'success' => false,
                    'reason' => "Langue not found"
                ], 404);
            }
            Langue::find($langue)->delete();
                return response()->json([
                    'success' => true,
                    'message' => "Langue deleted with success",
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
