<?php

namespace App\Http\Controllers;

use App\Modules\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use InvalidArgumentException;

class AuthController extends Controller
{
    protected AuthService $authService;

    /** Create a new AuthController instance.
     * @return void
     */

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

        $this->middleware('auth:api', [
            'except' => [
                'login',
                'register'
            ]]);
    }

    public function register(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $user = $this->authService->register($data);

            return response()->json($user, 201);

        } catch (InvalidArgumentException $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }

    }

    public function login(Request $request): JsonResponse
    {
        try {
            $token = $this->authService->login($request->all());

            return response()->json([
                'status' => 'success',
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer'
                ]
            ])->withCookie(
                'token',
                $token,
                config('jwt.ttl'),
                '/',
                null,
                true,
                true,
                false,
                "None"
            );
        } catch (InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }




//        The withCookie function expects the following parameters:
//
//        the name of the cookie
//        the value of the cookie
//        how many minutes the cookie should be valid
//        the path of the cookie
//        the domain of the cookie
//        whether the cookie should be secure
//        whether it is a http only cookie that can't be accessed by Javascript
//        whether to do urlencoding
//        a value for the SameSite attribute

    }


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

        $cookie = Cookie::forget('token');

        return response()->json(['message' => 'Successfully logged out'])->withCookie($cookie);
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
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
