<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)
            ->where('status', 'active')
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        $user->last_login_at = Carbon::now();
        $user->save();
        $tokenResult = $user->createToken('api-token');

        // Set token expiration (24 hours)
        if (isset($tokenResult->accessToken)) {
            $tokenResult->accessToken->expires_at = Carbon::now()->addDay();
            $tokenResult->accessToken->save();
            $expiresAt = $tokenResult->accessToken->expires_at->toDateTimeString();
        } else {
            $expiresAt = Carbon::now()->addDay()->toDateTimeString();
        }

        $plain = $tokenResult->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'nombre' => $user->name,
                'email' => $user->email,
                'rol' => $user->role,
                'token' => $plain,
                'token_type' => 'Bearer',
                'expires_in' => 86400,
                'expires_at' => $expiresAt,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'id' => Str::uuid()->toString(),
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'nombre' => $user->name,
                'email' => $user->email,
                'rol' => $user->role,
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 86400,
            ],
        ], 201);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'nombre' => $user->name,
                'email' => $user->email,
                'rol' => $user->role,
                'telefono' => $user->phone,
                'movil' => $user->mobile,
                'ubicacion_fisica' => $user->physical_address,
            ],
        ]);
    }
}
