<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Attribute;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GroupeAttribute;
use Illuminate\Support\Facades\Validator;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get(string $tech_name = null, string $groups = null, string $group_attribute = null, string $attribute = null,  $attribute_id = null)
    {
        // dd($group_attribute);
        // try {
            // Récupérer la classe spécifiée par son ID
            $components = Component::all();
            if ($tech_name != null) {
                $class = Classe::where('tech_name', $tech_name)->first();
                if ($groups != null) {
                    # code...
                    if ($groups == 'groups' && $group_attribute == null) {
                        
                        # code...
                            $groups = GroupeAttribute::where('classe_id', $class->id)->orderBy('position', 'ASC')->get();
                            //tous les groupes d'une classe
                            return response()->json([
                                'groups' => $groups,
                                'classes' => $class,
                                'components' => $components
                            ], Response::HTTP_OK);
                    }
                    else if($groups == 'groups' && is_numeric($group_attribute) ){
                        if ($attribute == null && is_numeric($group_attribute) ) {
                            $group_attribute = GroupeAttribute::where(['id' => $group_attribute])->first();
                            return response()->json([
                                'groups' => $group_attribute,
                                'classes' => $class,
                                'components' => $components
                            ], Response::HTTP_OK);
                        }else {
                            if ($attribute == 'attributes' && is_numeric($group_attribute) == true) {
                                if ($attribute_id == null) {
                                    $g_attribute = GroupeAttribute::where(['id' => $group_attribute])->first();
                                    $attributes = Attribute::where(['groupe_attribute_id' => $g_attribute->id])->orderBy('position', 'ASC')->get();
                                    
                                    $deep_attributes = [];
                                    foreach ($attributes as $key_attrib => $attribute) {
                                        $deep_attributes[$key_attrib] = Attribute::where(['id' => $attribute->id])->first()->ma($class->lang_id);
                                    }
                                    return response()->json([
                                        'attributes' => $attributes,
                                        'deep_attributes' => $deep_attributes,
                                        'groups' => $g_attribute,
                                        'classes' => $class,
                                        'components' => $components
                                    ], Response::HTTP_OK);
                                }else {
                                    if (is_numeric($attribute_id) == true) {
                                        # code...
                                        $all_classes = Classe::all();
                                        $g_attribute = GroupeAttribute::where(['id' => $group_attribute])->first();
                                        $attribute = Attribute::where([
                                            'id' => $attribute_id
                                            ])->first();
                                        return response()->json([
                                            'attributes' => $attribute,
                                            // 'deep_attributes' => $deep_attribute,
                                            'groups' => $g_attribute,
                                            'classes' => $class,
                                            'all_classes' => $all_classes,
                                            'components' => $components
                                        ], Response::HTTP_OK);
                                    }
                                }
                            }
                        }
                    }
                }
                $classe = Classe::findOrFail($class->id);
                return response()->json(['classes' => $classe], Response::HTTP_OK);
            }
            // Récupérer toutes les instances de la ressource Classe
            $classes = Classe::all();
            // Retourner une réponse JSON avec les classes récupérées
            return response()->json(['classes' => $classes], Response::HTTP_OK);
        // } catch (\Exception $e) {
        //     // En cas d'erreur, retourner une réponse avec un message d'erreur
        //     return response()->json(['error' => 'Une erreur est survenue lors de la récupération des classes.'], 500);
        // }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function post(Request $request)
    {
        // try {
            // Valider les données JSON de la requête
            $validator = Validator::make($request->json()->all(), [
                'lib' => 'required|string',
                'tech_name' => 'nullable|string',
                'company_id' => 'required|integer',
                'class_parent_id' => 'nullable|string',
                'component_multi_id' => 'nullable|integer',
                'component_unique_id' => 'nullable|integer',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Créer une nouvelle instance de la classe avec les données JSON
            $classe = Classe::create($request->json()->all());

            // Retourner une réponse JSON avec la classe créée
            return response()->json([
                'code' => 200,
                'message' => 'Classe crée avec succès',
                'classe' => $classe
            ], Response::HTTP_OK);
        // } catch (\Exception $e) {
        //     // En cas d'erreur, retourner une réponse avec un message d'erreur
        //     return response()->json([
        //         'code' => 404,
        //         'message' => 'Une erreur est survenue lors de la création de la classe.'],Response::HTTP_NOT_FOUND);
        // }
    }


    /**
     * Update the specified resource in storage.
     */
    public function put(Request $request, string $id)
    {
        try {
            // Valider les données JSON de la requête
            $validator = Validator::make($request->json()->all(), [
                'lib' => 'required|string',
                'tech_name' => 'required|string',
                'class_parent_id' => 'required|string',
                'company_id' => 'required|integer',
                'component_multi_id' => 'nullable|integer',
                'component_unique_id' => 'nullable|integer',
            ]);
    
            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
    
            // Récupérer la classe spécifiée par son ID
            $classe = Classe::findOrFail($id);
    
            // Mettre à jour les attributs de la classe avec les nouvelles données JSON
            $classe->update($request->json()->all());
    
            // Retourner une réponse JSON avec un message de succès
            return response()->json(['code' => 200, 'message' => 'Classe mise à jour avec succès.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['code' => 404, 'message' => 'Une erreur est survenue lors de la mise à jour de la classe.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            // Récupérer la classe spécifiée par son ID
            $classe = Classe::findOrFail($id);
            // Supprimer la classe
            $classe->delete();
            // Retourner une réponse JSON avec un message de succès
            return response()->json(['code' => 200, 'message' => 'Classe supprimée avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['code' => 404,  'message' => 'Une erreur est survenue lors de la suppression de la classe.'], 404);
        }
    }
}
