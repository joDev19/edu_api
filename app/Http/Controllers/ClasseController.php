<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classe::all();
        return response()->json([
            "success" => true,
            "data" => $classes,
            "message" => "Listes of classes"
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
            'code' => ['required'],
            'description' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        $classe = Classe::create($validator->validated());
        return response()->json([
            "success" => true,
            "data" => $classe,
            "message" => "epreuve created"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $classe)
    {
        if (!Classe::find($classe)) {
            return response()->json([
                "success" => false,
                "reason" => "Classe not found",
            ], 404);
        }
        $cl = Classe::find($classe);
        return response()->json([
            'success' => true,
            'message' => "Classe found",
            'data' => $cl
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classe $classe)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classe $classe)
    {
        $validator = Validator::make($request->all(), [
            'code' => [''],
            'description' => [''],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        if (!Classe::find($classe)) {
            return response()->json([
                "success" => false,
                "reason" => "Classe not found",
            ], 404);
        }
        $classe = Classe::all()->find($classe);
        $classe->update([
            'code' => ($request->code != null && $request->code != '') ? $request->code : $classe->code,
            'description' => ($request->description != null && $request->description != '') ? $request->description : $classe->description,
        ]);
        return response()->json([
            'success' => true,
            'message' => "Classe updated succesffully",
            'data' => $classe
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $classe)
    {
        if (!Classe::find($classe)) {
            return response()->json([
                "success" => false,
                "reason" => "Classe not found",
            ], 404);
        }
        Classe::find($classe)->delete();
        return response()->json([
            'success' => true,
            'message' => "Classe deleted succesffully",
            'data' => $classe
        ], 200);

    }
}
