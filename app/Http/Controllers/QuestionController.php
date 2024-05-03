<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'type' => ['required', Rule::in(['choix_unique', 'choix_multiple'])],
            'epreuve_id' => ['required', 'exists:epreuves,id'],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            $question = Question::create($validator->validated());
            return response()->json([
                "success" => true,
                "data" => $question,
                "message" => "question created"
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
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }

    public function reponses($id){
        try{
            if(!Question::find($id)){
                return response()->json([
                    'success' => false,
                    'reason' => "Question not found"
                ], 404);
            }
            $data = Question::find($id)->_reponses();
            return response()->json([
                'success' => true,
                'message' => "List of reponse of this question",
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
