<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
            'name' => 'required|string'
        ]);
        return User::create($request->all());
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string|min:3',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::claims(['service' => 'security'])->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $claims = [];
        if ($request->has('organization_type')) {
            if ($request->input('organization_type') == 'enduser' || $request->input('organization_type') == "agent") {
                $claims['organization_type'] = 'enduser';
                $claims['organization_id'] = $this->getOrganization($token, 'enduser');
            } else if ($request->input('organization_type') == 'distributor') {
                $claims['organization_type'] = 'distributor';
                $claims['organization_id'] = $this->getOrganization($token, 'distributor');
            } else if ($request->input('organization_type') == 'reseller') {
                $claims['organization_type'] = 'reseller';
                $claims['organization_id'] = $this->getOrganization($token, 'reseller');
            } else if ($request->input('organization_type') == 'client') {
                $claims['organization_type'] = 'client';
                $claims['organization_id'] = $this->getOrganization($token, 'client');
            }
        } else {
            $claims['organization_type'] = 'enduser';
            $claims['organization_id'] = $this->getOrganization($token, 'enduser');
        }

        if (!isset($claims['organization_id'])) {
            return response()->json(['error' => 'Unauthorized', 'message' => 'bu kullanıcı için seçilen rol bulunamadı'], 401);
        }
        $token = Auth::claims($claims)->attempt($credentials);
        return $this->respondWithToken($token);
    }

    public function getOrganization($token, $type = 'enduser')
    {
        try {
            $response = Http::withToken($token)->get('http://localhost:8000/organization/organizations?type=' . $type);
            $response = $response->body();
            $response = json_decode($response);
            $data = $response->data;
            if (count($data) > 0) {
                return $data[0]->id;
            }
            return null;
        } catch (\Exception $exception) {
            throw new \Exception('Hata servise ulaşılamadı');
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
