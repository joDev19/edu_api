<?php

namespace App\Http\Controllers;

use App\Models\EpreuvePdf;
use Illuminate\Http\Request;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;

class EpreuvePdfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(count($request->all()) > 0) {
            $query = EpreuvePdf::query(); // Initialisation correcte de la requête

            // filtre
            foreach ($request->all() as $params => $value) {
                $query->where($params, $value); // Ajout des conditions à la requête
            }

            return response()->json([
                'success' => true,
                'data' => $query->orderBy('id', 'desc')->paginate(15), // Exécution de la requête finale
                'message' => 'Liste des pdfs',
            ], 200);
        }
        $data = EpreuvePdf::orderBy('id', 'desc')->paginate(15);
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Liste des pdfs',
        ], 200);

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
    public function store(Request $request, FileService $fileService)
    {
        $validator = Validator::make($request->all(), [
            'session' => ['required'],
            'classe_id' => ['required', 'exists:classes,id'],
            'matiere_id' => ['required', 'exists:matieres,id'],
            'universite_id' => ['required', 'exists:universites,id'],
            'filiere_id' => ['required', 'exists:filieres,id'],
            'enoncer' => ['required', 'file', 'mimes:pdf'],
            'corriger' => ['required', 'file', 'mimes:pdf'],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        return EpreuvePdf::create([
            'session' => $request->session,
            'intitule' => $request->intitule,
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
            'universite_id' => $request->universite_id,
            'filiere_id' => $request->filiere_id,
            'path_enoncer' => $fileService->storeFile($request->file('enoncer')),
            'path_corriger' => $fileService->storeFile($request->file('corriger'), "corrigers"),
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(EpreuvePdf $epreuvePdf)
    {
        return response()->json([
            'success' => true,
            'data' => $epreuvePdf,
            'message' => 'Trouvé avec succès',
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EpreuvePdf $epreuvePdf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EpreuvePdf $epreuvePdf, FileService $fileService)
    {
        $validator = Validator::make($request->all(), [
            'intitule' => ['required'],
            'session' => ['required'],
            'classe_id' => ['required', 'exists:classes,id'],
            'matiere_id' => ['required', 'exists:matieres,id'],
            'universite_id' => ['required', 'exists:universites,id'],
            'filiere_id' => ['required', 'exists:filieres,id'],
            //'enoncer' => ['required', 'file', 'mimes:pdf'],
            //'corriger' => ['required', 'file', 'mimes:pdf'],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        $epreuvePdf->intitule = $request->intitule;
        $epreuvePdf->session = $request->session;
        $epreuvePdf->classe_id = $request->classe_id;
        $epreuvePdf->matiere_id = $request->matiere_id;
        $epreuvePdf->universite_id = $request->universite_id;
        $epreuvePdf->filiere_id = $request->filiere_id;
        if($request->file('enoncer')){
            // supprimer l'ancien et stocker le nouveau
            $epreuvePdf->path_enoncer = $request->filiere_id;
        }
        if($request->file('corriger')){
            // supprimer l'ancien et stocker le nouveau
            $epreuvePdf->path_corriger = $request->filiere_id;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EpreuvePdf $epreuvePdf)
    {
        //
    }
}
