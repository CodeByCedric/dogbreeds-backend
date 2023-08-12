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
                'token', //name
                $token, //value
                config('jwt.ttl'), //minutes
                '/', //path, specifies the URL path for which the cookie is valid.
                null, //domain, the domain for which the cookie is valid. If not set, the cookie will be valid for the current domain by default. (for use with subdomains)
                true, //secure, indicates if the cookie should only be sent over HTTPS.
                true, //httpOnly, whether it can be accessed by JavaScript
                false, //raw, whether to do urlencoding, if true, the cookie value will not be URL encoded before being set. This can be useful in cases where you need to ensure that the value is in a specific format.
                "None" /*sameSite (String): This is a newer attribute that provides some CSRF (cross-site request forgery) protection. The possible values are:
                          'Lax': The cookie is only sent to the server when the request's origin is the same as the target origin, or when navigating from the target site.
                          'Strict': The cookie is only sent to the server when the request’s origin is the same as the target origin (i.e., not for cross-origin requests).
                          'None': The cookie will be sent with all requests, both cross-origin and same-origin.*/
            );
        } catch (InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        $cookie = Cookie::forget('token');

        return response()->json(['message' => 'Successfully logged out'])->withCookie($cookie);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());

    }

    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);

    }
}
