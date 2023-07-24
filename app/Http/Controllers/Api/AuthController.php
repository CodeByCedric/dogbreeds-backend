<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'login',
                'register'
            ]]);
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User Registered Successfully',
            'user' => $user,
            'token' => $token
        ]);

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */

    public function login(Request $request): JsonResponse
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logged in successfully',
            'token' => $token,
        ]);

    }
//    public function login(): JsonResponse
//    {
//
//
//        $credentials = request(['email', 'password']);
//
//        if (! $token = auth()->attempt($credentials)) {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }
//
//        return $this->respondWithToken($token);
//    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
