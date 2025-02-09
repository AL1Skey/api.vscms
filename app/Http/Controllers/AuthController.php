<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use \Laravel\Sanctum\PersonalAccessToken;

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
                $token = auth()->user()->createToken('Personal Access Token', ['expires_at' => now()->addHours(12)])->plainTextToken;
                
                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 401);
        }
    }

    // Override behaviour of unauthenticated method
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    public function verify(Request $request)
    {
        try{
            $bearer = $request->bearerToken();
            $token = explode(' ', $bearer)[0];
            // [$id, $token] = explode('|', $token[0]);
            $token = PersonalAccessToken::findToken($token);
            // [$id, $token] = explode('|', $token[0]);
            // $token = Token::where('token', )->first();
            // dd(Token::all());
            if($token){
                return response()->json(['status' => true], 200);
            }else{
                return response()->json(['status' => false], 401);
            }
        }
        catch(\Throwable $th){
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
        try {
            $request->user()->token()->revoke();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 401);
        }
    }

    public function user(Request $request)
    {
        try {
            return response()->json($request->user());
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 401);
        }
    }

    public function validate($request, $array)
    {
        return $request->validate($array);
    }
    
}
