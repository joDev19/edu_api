<?php

namespace App\Http\Controllers;

use App\Models\Epreuve;
use App\Models\Question;
use App\Models\Reponse;
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
    /**
     * Store a qcm with his questions and his response
    */
    public function store_qcm(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'epreuve' => ['required','array:intitule,duree,niveau_de_difficulte_id,matiere_id,classe_id'],
            'epreuve.*' => ['required'],
            'epreuve.duree' => ['date_format:H:i'],
            'epreuve.niveau_de_difficulte_id' => ['exists:niveau_de_difficultes,id'],
            'epreuve.matiere_id' => ['exists:matieres,id'],
            'epreuve.classe_id' => ['exists:classes,id'],
            'questions' => ['required', 'array'],
            //'questions.*'=> ['required', 'array:intitule,is_qcm,reponse'],
            //'questions.*.*'=> ['required'],
            'questions.*.is_qcm' => ['required','boolean'],
            'questions.*.intitule' => ['required'],
            //'questions.*.reponse' => ['array:intitule,is_true'],
            //'questions.*.reponse.*' => ['required'],
            //'questions.*.reponse.is_true' => ['boolean'],

        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }

        //dd($request->epreuve, $request->questions);
        // CREATE EPREUVE
        $epreuve = Epreuve::create([
            'intitule' => $request->epreuve['intitule'],
            "duree" => $request->epreuve['duree'],
            "niveau_de_difficulte_id" => $request->epreuve['niveau_de_difficulte_id'],
            "matiere_id" => $request->epreuve['matiere_id'],
            "classe_id" => $request->epreuve['classe_id'],
        ]);
        // question
        foreach ($request->questions as $key => $question) {

            $_question = Question::create([
                'intitule' => $question['intitule'],
                'type' => $question['is_qcm'] ? 'choix_multiple' : 'choix_unique',
                'epreuve_id' => $epreuve->id,
            ]);
            foreach($question['reponse'] as $k => $reponse){
                Reponse::create([
                    'intitule' => $reponse['intitule'],
                    'juste' => $reponse['is_true'],
                    'question_id' => $_question->id
                ]);
            }

        }
        return response()->json([
            'success' => true,
            'message' => "qcm is created",
            'data' => Epreuve::find($epreuve->id),
        ], 200);
    }
    public function update_qcm(Request $request, $id){
        if(!Epreuve::find($id)){
            return response()->json([
                'success' => false,
                'reason' => "Epreuve not found"
            ], 404);
        }
        // mise a jour de l'epreuve
        $qcm = Epreuve::find($id);
        $qcm->update([
            'intitule' => '',
            'share' => 1,
            'niveau_de_difficulte_id' => '',
            'matiere_id' => '',
            'duree' => '',
            'classe_id' => '',

        ]);
        // question .... deletetion (it will delete the response also)
        dd($qcm->_questions()->delete());
        // creation of question & reponses
        foreach ($request->questions as $key => $question) {

            $_question = Question::create([
                'intitule' => $question['intitule'],
                'type' => $question['is_qcm'] ? 'choix_multiple' : 'choix_unique',
                'epreuve_id' => $epreuve->id,
            ]);
            foreach($question['reponses'] as $k => $reponse){
                Reponse::create([
                    'intitule' => $reponse['intitule'],
                    'juste' => $reponse['is_true'],
                    'question_id' => $_question->id
                ]);
            }

        }
    }

}
