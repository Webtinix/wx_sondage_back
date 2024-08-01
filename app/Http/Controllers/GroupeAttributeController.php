<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GroupeAttribute;
use Illuminate\Support\Facades\Validator;

class GroupeAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get($id = null)
    {
        try {
            if ($id !== null) {
                # code...
                // Récupérer le groupe d'attributs spécifié par son ID
                $groupeAttribute = GroupeAttribute::findOrFail($id);
                return response()->json(["groupeAttribute" => $groupeAttribute]);
            }
            // Récupérer toutes les instances de la ressource GroupeAttribute
            $groupeAttributes = GroupeAttribute::all();
            
            // Retourner une réponse JSON avec les groupes d'attributs récupérés
            return response()->json($groupeAttributes);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des groupes d\'attributs.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function post(Request $request)
    {
        try {
            // Valider les données JSON de la requête
            $validator = Validator::make($request->json()->all(), [
                'classe_id' => 'required|integer|exists:classes,id',
                'position' => 'nullable|integer',
                'attr' => 'nullable|string',
                'lib' => 'required|string',
                'component_id_multi' => 'nullable|integer',
                'component_id_unique' => 'nullable|integer',
            ]);
            $data = $request->json()->all();
            // dd($request->json()->all());
            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            $gac = Component::where(['lib' => 'com.webtinix.infusio.GroupeAttributes'])->first();
            if ($data['component_id_multi'] == null) {
                # code...
                $data['component_id_multi']  = $gac->id;
            }

            if ($data['component_id_unique'] == null) {
                # code...
                $data['component_id_unique']  = $gac->id;
            }
            

            // Créer une nouvelle instance du groupe d'attributs
            $groupeAttribute = GroupeAttribute::create($request->json()->all());

            // Retourner une réponse JSON avec le groupe d'attributs créé
            return response()->json([
                'code' => 200,
                'message' => 'Le groupe d\'attributs a été créé',
                'groupeAttribute' => $groupeAttribute
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['code' => 404,'message' => 'Une erreur est survenue lors de la création du groupe d\'attributs.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function put(Request $request, string $id)
    {
        try {
            // Valider les données JSON de la requête
            $validator = Validator::make($request->json()->all(), [
                'classe_id' => 'required|integer|exists:classes,id',
                'position' => 'nullable|integer',
                'attr' => 'nullable|string',
                'lib' => 'required|string',
                'component_multi' => 'nullable|integer',
                'component_unique' => 'nullable|integer',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Récupérer le groupe d'attributs spécifié par son ID
            $groupeAttribute = GroupeAttribute::findOrFail($id);

            // Mettre à jour les attributs du groupe d'attributs avec les nouvelles données JSON
            $groupeAttribute->update($request->json()->all());

            // Retourner une réponse JSON avec un message de succès
            return response()->json([
                'code' => 200,
                'message' => 'Groupe d\'attributs mis à jour avec succès.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['code' => 404,'message' => 'Une erreur est survenue lors de la mise à jour du groupe d\'attributs.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            // Récupérer le groupe d'attributs spécifié par son ID
            $groupeAttribute = GroupeAttribute::findOrFail($id);
            // Supprimer le groupe d'attributs
            $groupeAttribute->delete();
            // Retourner une réponse JSON avec un message de succès
            return response()->json(['code' => 200, 'message' => 'Groupe d\'attributs supprimé avec succès.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['code' => 404,'message' => 'Une erreur est survenue lors de la suppression du groupe d\'attributs.'], Response::HTTP_NOT_FOUND);
        }
    }
}
