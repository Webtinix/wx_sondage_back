<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\User;  // add the User model

class UserController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function me()
    {
        try {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'User fetched successfully!',
                ],
                'data' => [
                    'user' => auth()->user(),
                ],
            ]);
                        return response()->json(['code' => 200, 'message' => 'Succès' ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'status' => 'error',
                ]
                ]);
        }
    }

    public function get($id = null) {
        try {
            //code...
            if ($id) {
                $user = $this->user->findOrFail($id);
                return response()->json([
                    'user' => $user,Response::HTTP_OK
                ]);
            }
            $users = $this->user->all();
            return response()->json([
                    'users' => $users,
                    'code' => 200,
                    'message' => 'Succès'
            ],Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'code' => 404,
                'message' => 'User not found!',
            ],Response::HTTP_NOT_FOUND);
        }
    }

    public function put(Request $request, $id) {
        try {
            //code...
            $user = $this->user->findOrFail($id);
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->fonction = $request->fonction;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->telephone = $request->telephone;
            $user->status = $request->status;
            if ($request->password != "") {
                # code...
                $user->password = $request->password;
            }

            $user->save();
            return response()->json([
                'code' => 200,
                'message' => 'User updated successfully!',
                'user' => $user
            ],Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'code' => 404,
                'message' => 'User not found!',
            ],Response::HTTP_NOT_FOUND);
        }
    }

    public function delete(Request $request) {
        try {
            //code...
            $user = $this->user->findOrFail($request->id);
            $user->delete();
            return response()->json([
                'code' => 200,
                'message' => 'User deleted successfully!',
            ],Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'code' => 404,
                'message' => 'User not found!',
            ],Response::HTTP_NOT_FOUND);
        }
    }
    
}