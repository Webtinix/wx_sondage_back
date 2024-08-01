<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\User;
use App\Models\Classe;
use App\Models\Instance;
use App\Models\Attribute;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GroupeAttribute;

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
        //creation des trois classe 

        $inscription_1 = Classe::create([
            'lib' => 'Formulaire de participation', 
            'tech_name' => 'formulaire_de_participation', 
            'company_id' =>2,
            'component_multi_id' => Component::where(['lib' => 'com.webtinix.infusio.server.SondageResult'])->first()->id,
            'component_unique_id' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);

        $inscription_2 = Classe::create([
            'lib' => 'Formulaire d’inscription au 72h chrono Emploi ou stage', 
            'tech_name' => 'formulaire_d_inscription_au_72h_chrono_emploi_ou_stage', 
            'company_id' =>2,
            'component_multi_id' => Component::where(['lib' => 'com.webtinix.infusio.server.SondageResult'])->first()->id,
            'component_unique_id' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);

        $inscription_3 = Classe::create([
            'lib' => 'Formulaire d’inscription au Challenge Projet de soutenance', 
            'tech_name' => 'formulaire_d_inscription_au_challenge_projet_de_soutenance', 
            'company_id' =>2,
            'component_multi_id' => Component::where(['lib' => 'com.webtinix.infusio.server.SondageResult'])->first()->id,
            'component_unique_id' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);

        // creation des options 


                $liste_des_options_par_defaut_genre = Classe::create([
                    'lib' => 'liste_des_options_par_defaut', 
                    'tech_name' => 'liste_des_options_par_defaut_du_sondage', 
                    'company_id' => 2,
                    'component_multi_id' => Component::where(['lib' => 'com.webtinix.infusio.server.SondageResult'])->first()->id,
                    'component_unique_id' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
                ]);

                $gac_options = Component::where(['lib' => 'com.webtinix.infusio.GroupeAttributes'])->first();
                $group_liste_des_options_par_defaut_genre = GroupeAttribute::create([
                    'classe_id' => $liste_des_options_par_defaut_genre->id, 
                    'position' => 1, 
                    'lib' => 'liste_des_options_par_defaut_du_sondage' . $liste_des_options_par_defaut_genre->id, 
                    'attr' => '{"className":"grid gap-4"}', 
                    'component_id_multi' => $gac_options->id, 
                    'component_id_unique' => $gac_options->id
                ]);

                $attribute_option = Attribute::create([
                    'tech_name' => 'attribute_option'.$liste_des_options_par_defaut_genre->tech_name,
                    'classe_id' => $liste_des_options_par_defaut_genre->id,
                    'groupe_attribute_id' => $group_liste_des_options_par_defaut_genre->id,
                    'lib' => 'Description du genre',
                    'position' => 1,
                    'required' => 0,
                    'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                    'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                    'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
                ]);

                $data_create_ins = ['classe_id' => $liste_des_options_par_defaut_genre->id, 'parent_id' => null];
                $instance1 = Instance::create($data_create_ins);
                Data::create(['instance_id' => $instance1->id, 'class_id' => $liste_des_options_par_defaut_genre->id, 'value' =>'M' , 'attribute_id' => $attribute_option->id]);
                $instance2 = Instance::create($data_create_ins);
                Data::create(['instance_id' => $instance2->id, 'class_id' => $liste_des_options_par_defaut_genre->id, 'value' =>'F' , 'attribute_id' => $attribute_option->id]);
                // $instance3 = Instance::create($data_create_ins);
                // Data::create(['instance_id' => $instance3->id, 'class_id' => $liste_des_options_par_defaut->id, 'value' =>'Satisfait' , 'attribute_id' => $attribute_option->id]);
                // $instance4 = Instance::create($data_create_ins);
                // Data::create(['instance_id' => $instance4->id, 'class_id' => $liste_des_options_par_defaut->id, 'value' =>'Tres satisfait' , 'attribute_id' => $attribute_option->id]);

        //creation des groupes
        $gac = Component::where(['lib' => 'com.webtinix.infusio.GroupeAttributes'])->first();

        $group_inscription_1 = GroupeAttribute::create([
            'classe_id' => $inscription_1->id, 
            'position' => 1, 
            'lib' => 'inscription_1' . $inscription_1->id, 
            'attr' => '{"className":"grid gap-4"}', 
            'component_id_multi' => $gac->id, 
            'component_id_unique' => $gac->id
        ]);

        $group_inscription_2 = GroupeAttribute::create([
            'classe_id' => $inscription_2->id, 
            'position' => 1, 
            'lib' => 'inscription_2' . $inscription_2->id, 
            'attr' => '{"className":"grid gap-4"}', 
            'component_id_multi' => $gac->id, 
            'component_id_unique' => $gac->id
        ]);

        $group_inscription_3 = GroupeAttribute::create([
            'classe_id' => $inscription_3->id, 
            'position' => 1, 
            'lib' => 'inscription_3' . $inscription_3->id, 
            'attr' => '{"className":"grid gap-4"}', 
            'component_id_multi' => $gac->id, 
            'component_id_unique' => $gac->id
        ]);

        // création des attributs
            // 1-les attributs communs aux trois formulaires
                //nom
            $nom_inscription_1 = Attribute::create([
                'tech_name' => 'nom'.$inscription_1->tech_name,
                'classe_id' => $inscription_1->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_1->id,
                'lib' => "Nom(s)",
                'position' => 1,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $nom_inscription_2 = Attribute::create([
                'tech_name' => 'nom'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' => "Nom(s)",
                'position' => 1,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $nom_inscription_3 = Attribute::create([
                'tech_name' => 'nom'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' => "Nom(s)",
                'position' => 1,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // prenom

            $prenom_inscription_1 = Attribute::create([
                'tech_name' => 'prenom'.$inscription_1->tech_name,
                'classe_id' => $inscription_1->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_1->id,
                'lib' => "Prénom(s)",
                'position' => 2,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $prenom_inscription_2 = Attribute::create([
                'tech_name' => 'prenom'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' => "Prénom(s)",
                'position' => 2,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $prenom_inscription_3 = Attribute::create([
                'tech_name' => 'prenom'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' => "Prénom(s)",
                'position' => 2,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            //Genre

            $genre_inscription_1 = Attribute::create([
                'tech_name' => 'genre'.$inscription_1->tech_name,
                'classe_id' => $inscription_1->id,
                'classe_src_id' => $liste_des_options_par_defaut_genre->id,
                'groupe_attribute_id' => $group_inscription_1->id,
                'lib' => "Genre",
                'position' => 3,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputSelect'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $genre_inscription_2 = Attribute::create([
                'tech_name' => 'genre'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                'classe_src_id' => $liste_des_options_par_defaut_genre->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' => "Genre",
                'position' => 3,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputSelect'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $genre_inscription_3 = Attribute::create([
                'tech_name' => 'genre'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                'classe_src_id' => $liste_des_options_par_defaut_genre->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' => "Genre",
                'position' => 3,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputSelect'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Téléphone 

            $telephone_inscription_1 = Attribute::create([
                'tech_name' => 'telephone'.$inscription_1->tech_name,
                'classe_id' => $inscription_1->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_1->id,
                'lib' => "Téléphone",
                'position' => 4,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $telephone_inscription_2 = Attribute::create([
                'tech_name' => 'telephone'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' => "Téléphone",
                'position' => 4,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $telephone_inscription_3 = Attribute::create([
                'tech_name' => 'telephone'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' => "Téléphone",
                'position' => 4,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Email

            $email_inscription_1 = Attribute::create([
                'tech_name' => 'email'.$inscription_1->tech_name,
                'classe_id' => $inscription_1->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_1->id,
                'lib' => "Email",
                'position' => 5,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $email_inscription_2 = Attribute::create([
                'tech_name' => 'email'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' => "Email",
                'position' => 5,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $email_inscription_3 = Attribute::create([
                'tech_name' => 'email'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' => "Email",
                'position' => 5,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

             // 1-les attributs communs aux trois formulaires 2 et 3

            //  Date de naissance
            $date_de_naissance_inscription_2 = Attribute::create([
                'tech_name' => 'date_de_naissance'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' => "Date de naissance",
                'position' => 6,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputDate'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $date_de_naissance_inscription_3 = Attribute::create([
                'tech_name' => 'date_de_naissance'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' => "Date de naissance",
                'position' => 6,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputDate'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Lieu de naissance

            $lieu_de_naissance_inscription_2 = Attribute::create([
                'tech_name' => 'lieu_de_naissance'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' => "Lieu de naissance",
                'position' => 7,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $lieu_de_naissance_inscription_3 = Attribute::create([
                'tech_name' => 'lieu_de_naissance'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' => "Lieu de naissance",
                'position' => 7,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Ville

            $ville_inscription_2 = Attribute::create([
                'tech_name' => 'ville'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' => "Ville",
                'position' => 8,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $ville_inscription_3 = Attribute::create([
                'tech_name' => 'ville'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' => "Ville",
                'position' => 8,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Arrondissement

            $arrondissement_inscription_2 = Attribute::create([
                'tech_name' => 'arrondissement'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' =>"Arrondissement",
                'position' => 9,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $arrondissement_inscription_3 = Attribute::create([
                'tech_name' => 'arrondissement'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' =>"Arrondissement",
                'position' => 9,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Quartier
            
            
            
            $quartier_inscription_2 = Attribute::create([
                'tech_name' => 'quartier'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' =>"Quartier",
                'position' => 10,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $quartier_inscription_3 = Attribute::create([
                'tech_name' => 'quartier'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' =>"Quartier",
                'position' => 10,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // CV

            $cv_inscription_2 = Attribute::create([
                'tech_name' => 'cv'.$inscription_2->tech_name,
                'classe_id' => $inscription_2->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_2->id,
                'lib' =>"CV",
                'position' => 11,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputFile'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $cv_inscription_3 = Attribute::create([
                'tech_name' => 'cv'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' =>"CV",
                'position' => 11,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputFile'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // champs d'information spécifiques à chaque formulaire

            // Profession

            $profession_inscription_1 = Attribute::create([
                'tech_name' => 'profession'.$inscription_1->tech_name,
                'classe_id' => $inscription_1->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_1->id,
                'lib' => "Profession",
                'position' => 6,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Noms du porteur de projet

            $n_porteur_projet_inscription_3 = Attribute::create([
                'tech_name' => 'n_porteur_projet'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' =>"Noms du porteur de projet",
                'position' => 12,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Prenoms du porteur de projet
            $p_porteur_projet_inscription_3 = Attribute::create([
                'tech_name' => 'p_porteur_projet'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' =>"Prenoms du porteur de projet",
                'position' => 13,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Titre du Projet de soutenance

            $titre_du_projet_inscription_3 = Attribute::create([
                'tech_name' => 'titre_du_projet'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' =>"Titre du Projet de soutenance",
                'position' => 14,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Niveau 
            $niveau_inscription_3 = Attribute::create([
                'tech_name' => 'niveau'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' =>"Niveau",
                'position' => 15,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

             // Secteur 
            $secteur_inscription_3 = Attribute::create([
                'tech_name' => 'secteur_'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' =>"Secteur",
                'position' => 16,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

             // theme 
            $theme_inscription_3 = Attribute::create([
                'tech_name' => 'theme'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' =>"Thème",
                'position' => 17,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.TextArea'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            // Description du Projet de soutenance 
            $description_projet_inscription_3 = Attribute::create([
                'tech_name' => 'description_projet'.$inscription_3->tech_name,
                'classe_id' => $inscription_3->id,
                // 'classe_src_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_inscription_3->id,
                'lib' =>"Description du Projet de soutenance",
                'position' => 18,
                'required' => 1,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.TextArea'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);


    }
}
