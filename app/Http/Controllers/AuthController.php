<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        try {
            //code...
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                $token = auth()->user()->createToken('Personal Access Token')->plainTextToken;
                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 401);
        }
    }

    public function register(Request $request)
    {
        try {
            //code...
            $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6',
                ]);
            // dd("user");
                
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
    
            // $token = $user->createToken('Personal Access Token')->accessToken;
            $user->save();
    
            return response()->json(['msg' => "User has been succesfully created"], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function validate($request, $array)
    {
        return $request->validate($array);
    }
    
}
