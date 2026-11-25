<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\JwtTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request, JwtTokenService $tokens): JsonResponse
    {
        $credentials = $request->validated();
        $user = User::query()->where('email', $credentials['email'])->first();

        if ($user === null || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'access_token' => $tokens->issueFor($user),
            'token_type' => 'Bearer',
            'expires_in' => (int) config('jwt.ttl_minutes') * 60,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], JsonResponse::HTTP_OK);
    }
}
