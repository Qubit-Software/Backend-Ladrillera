<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // Validates data and redirects if failed
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->save();
        // Save to Usuario table
        $usuario = new Usuario([
            'nombre' => $request['name'],
            'correo' => $request['email'],
            'contraseña' => bcrypt($request['password']),
            'auth_user_id' => $user->id,
        ]);
        $usuario->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        // Check for user credentials
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Sin autorización'
            ], 401);
        }
        $user = $request->user();
        $isActive = Usuario::where('auth_user_id', '=', $user->id)->first();
        if (!$isActive) {
            return response()->json([
                'message' => 'No tienes una cuenta activa'
            ], 401);
        }
        // Create new token for the authenticated user 
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        } else {
            $token->expires_at = Carbon::now()->addDay();
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' =>
        'Successfully logged out']);
    }

    public function user(Request $request)
    {
        // Get the user making the request throught the api guard
        return response()->json($request->user());
    }
}
