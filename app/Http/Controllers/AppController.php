<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Instance;
use App\Models\Attribute;
use App\Models\Data;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppController extends Controller
{

    /**
     * Get a listing of the resource.
     *
     * @middleware powerbi
     */

    /**
    * @OA\Get(
    *      path="/api/v1/formations/{id?}",
    *      summary="Liste des Formations",
    *      tags={"Formations"},
    *      description="Formations List Endpoint.",
    *      @OA\Parameter(in="header", required=true, name="API-KEY", @OA\Schema(type="string")),
    *      @OA\Parameter(in="path", required=false, name="id", @OA\Schema(type="integer")),
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\JsonContent(
    *              @OA\Property(
    *                property="formations",
    *                type="object",
    *                properties={
    *                      @OA\Property(property="id", type="integer"),
    *                      @OA\Property(property="libelle", type="string"),
    *                      @OA\Property(property="description", type="string"),
    *                      @OA\Property(property="nombreEtudiants", type="integer"),
    *                      @OA\Property(property="utilisateurId", type="integer"),
    *                      @OA\Property(property="createAt", type="date"),
    *                      @OA\Property(property="updateAt", type="date"),
    *                  }
    *              ),@OA\Property(
    *                property="reponseSondage",
    *                type="object",
    *                properties={
    *                      @OA\Property(property="id", type="integer"),
    *                      @OA\Property(property="lib", type="string"),
    *                      @OA\Property(property="type", type="string"),

    *           
    *                  }
    *              ),@OA\Property(
    *                property="questionSndage",
    *                type="object",
    *                properties={                
    *                      @OA\Property(property="id", type="integer"),
    *                      @OA\Property(property="value", type="string"),
    *                      @OA\Property(property="questionId", type="integer"),
    *                      @OA\Property(property="date", type="date"),
    }
    *              )
    *         ),
    *      ),
    * )
    
 */
    public function get(Request $request, string $id = null, string $tech_name = 'formations')
    {
        $token = $request->header('API-KEY');
        if ($token != env('POWER_BI_KEY')) {
            # code...
            return response()->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }
        if ($id != null) {
            $formations = Classe::where(['tech_name' => 'formation'])->first()->instances()->where(['id' => $id])->first()->pBif();
                return response()->json( [
                    'formations' => $formations
                ], Response::HTTP_OK);
        }else{
            $all_instances = Classe::where(['tech_name' => 'formation'])->first()->instances()->get();
            $formations = [];
            foreach ($all_instances as $key => $instance) {
                $formations[] = $instance->pBif();
            }
            return response()->json([
                'formations' => $formations
            ], Response::HTTP_OK);
        }
    }


    /**
    * @OA\Get(
    *      path="/api/v1/utilisateurs/{id?}",
    *      summary="Liste des utilisateurs",
    *      tags={"utilisateurs"},
    *      description="Point de terminaison Liste des utilisateurs.",
    *      @OA\Parameter(in="header", required=true, name="API-KEY", @OA\Schema(type="string")),
    *      @OA\Parameter(in="path", required=false, name="id", @OA\Schema(type="string")),
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\JsonContent(
    *              @OA\Property(
    *                property="utilisateurs",
    *                type="object",
    *                properties={
    *                      @OA\Property(property="id", type="integer"),
    *                      @OA\Property(property="nom", type="string"),
    *                      @OA\Property(property="prenom", type="string"),
    *                      @OA\Property(property="telephone", type="string"),
    *                      @OA\Property(property="role", type="string"),
    *                      @OA\Property(property="fonction", type="string"),
    *                      @OA\Property(property="email", type="string"),
    *                      @OA\Property(property="createAt", type="date"),
    *                      @OA\Property(property="updateAt", type="date"),
    *                  }
    *              ),
    *         ),
    *      ),
    * )
    
 */

    public function utilisateurs(Request $request, string $id = null)
    {
        $token = $request->header('API-KEY');
        if ($token != env('POWER_BI_KEY')) {
            return response()->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }
        try {
            if ($id) {
                $user = User::where(['id' => $id])->first();
                return response()->json([
                    'utilisateurs' => $user
                ]);
            }
            $users = User::get()->all();
            return response()->json([
                    'utilisateurs' => $users,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'code' => 404,
                'message' => 'User not found!',
            ],Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function debug(Request $request)
    {

        // $c = Classe::where(['id' => 49])->first()->me(1)['instances'];
        $d = Data::where(['id' => 290])->first()->getDataValue();
        // dd($d);
        // $d = Instance::where(['id' => 49])->first();
        // $a = Attribute::where(['id' => 13])->first();
        // $aj = json_decode($a,true);
        // // dd($aj);
        // $aj['lib'] = $a->attributeLangs()->first()->lib;
        // dd($aj);
        
        // foreach ($d->datas()->get() as $key => $value) {
        //     # code...
        //     dump($value->delete(),true);
        // }

    }
}
