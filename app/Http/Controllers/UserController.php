<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Récupération de mot de passe
     */
    public function recuperation_de_mot_de_passe(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            $user = User::where('email', $request->email)->first();
            $password = '12345';
            $user->password = Hash::make($password);
            $user->save();
            //send mail which contain the new password
            return response()->json([
                "success" => true,
                "data" => null,
                "message" => "Password Resset success: 12345"
            ]);
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "reason" => 'Error: '.$e->getMessage(),
            ], 500);
        }

    }
    /**
     * Return all the students
     */
    public function all_student(){
        try{
            $students = User::where('role', '=', 'Student')->paginate(10);
            return response()->json([
                "success" => true,
                "data" => $students,
                "message" => "Listes of students"
            ]);
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "reason" => 'Error: '.$e->getMessage(),
            ], 500);
        }

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $users = User::all();
            return response()->json([
                "success" => true,
                "data" => $users,
                "message" => "Listes of user"
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'telephone' => ['required'],
            'password' => ['required'],
            'role' => [''],
            'langue_id' => [''],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            $user = User::create($validator->validated());
            return response()->json([
                "success" => true,
                "data" => $user,
                "message" => "user created"
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
    public function show($id)
    {
        if(!User::find($id)){
            return response()->json([
                "success" => false,
                "reason" => "User not found",
            ], 404);
        }
        try{
            $user = User::find($id);
            return response()->json([
                'success' => true,
                'message' => "User found",
                'data' => $user
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [],
            // 'email' => [],
            'telephone' => [],
            // 'password' => [],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            if(!User::find($id)){
                return response()->json([
                    'success' => false,
                    'reason' => "User not found"
                ], 404);
            }
            User::find($id)->update($validator->validated());
                return response()->json([
                    'success' => true,
                    'message' => "User updated with success",
                    'data' => User::find($id)
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
    public function destroy(string $id)
    {
        try{
            if(!User::find($id)){
                return response()->json([
                    'success' => false,
                    'reason' => "User not found"
                ], 404);
            }
            User::find($id)->delete();
                return response()->json([
                    'success' => true,
                    'message' => "User deleted with success",
                    'data' => null
                ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'reason' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }

    public function connexion(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ["required", "email"],
            'password' => ["required"],
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'reason' => $validator->getMessageBag()->first()
            ], 422);
        }
        try{
            if(!Auth::attempt($validator->validated())){
                return response()->json([
                    'success' => false,
                    'reason' => "Bad credentials"], 401
                );
            }
            $user = Auth::user();
            $token = $request->user()->createToken('token');
            return response()->json([
                'success' => true,
                'message' => "User connected",
                'data' => $user,
                'token' => $token->plainTextToken
            ]);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'reason' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }

    public function deconnexion(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                "success" => true,
                "data" => null,
                "message" => "User disconected"
            ]);
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "reason" => 'Error: '.$e->getMessage(),
            ], 500);
        }
    }
}
