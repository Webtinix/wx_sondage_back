<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        // model as dependency injection
        $this->user = $user;
    }

    public function register(Request $request)
    {
        // validate request
        $validator = Validator::make($request->json()->all(), [
            'nom' => 'required|string',
            'prenom' => 'required|prenom',
            'telephone' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|string',
            'status' => 'nullable|string',
            'fonction' => 'nullable|string',
        ]);

        // if the request valid, create user

        $user = $this->user::create([
            'nom' => $request['nom'],
            'prenom' => $request['prenom'],
            'telephone' => $request['telephone'],
            'password' => bcrypt($request['password']),
            'email' => $request['email'],
            'role' => $request['role'],
            'status' => $request['status'],
            'fonction' => $request['fonction'],

        ]);

        // login the user immediately and generate the token
        $token = auth()->login($user);

        // return the response as json
        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User created successfully!',
            ],
            'data' => [
                'user' => $user,
                'access_token' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => auth()->factory()->getTTL() * 1000,    // get token expires in seconds
                ],
            ],
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // attempt a login (validate the credentials provided)
        $token = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // dd($token);
        // if token successfully generated then display success response
        // if attempt failed then "unauthenticated" will be returned automatically
        if ($token)
        {
            // dd(auth()->factory()->getTTL() * 6000);
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Quote fetched successfully.',
                ],
                'data' => [
                    'user' => auth()->user(),
                    'access_token' => [
                        'token' => $token,
                        'type' => 'Bearer',
                        'expires_in' => (auth()->factory()->getTTL() ),
                        'actual_time' =>  round(microtime(true) * 1000),
                    ],
                ],
            ]);
        }else
        {
            return response()->json([
                'meta' => [
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Invalid credentials.',
                ],
                'data' => [],
            ]);
        }
    }

    public function logout()
    {
        // get token
        $token = JWTAuth::getToken();
        // invalidate token
        $invalidate = JWTAuth::invalidate($token);
        if($invalidate) {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Successfully logged out',
                ],
                'data' => [],
            ]);
        }
    }

}
