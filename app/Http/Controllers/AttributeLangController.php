<?php

namespace App\Http\Controllers;

use App\Models\AttributeLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class AttributeLangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get($id = null)
    {
        try {
            if ($id != null) {
                # code...
                $attributeLang = AttributeLang::findOrFail($id);
                // Retourner une réponse JSON avec les détails de la langue attribut
                return response()->json(['attributeLang' => $attributeLang]);
            }
            // Récupérer toutes les instances de la ressource AttributeLang
            $attributeLangs = AttributeLang::all();
            // Retourner une réponse JSON avec les langues attribut récupérées
            return response()->json(["attributeLangs" => $attributeLangs]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des langues attribut.'], 500);
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
                'lib' => 'required|string',
                'lang_id' => 'required|integer|exists:langs,id',
                'attribute_id' => 'required|integer|exists:attributes,id',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Créer une nouvelle instance de la langue attribut
            $attributeLang = AttributeLang::create($request->json()->all());

            // Retourner une réponse JSON avec la langue attribut créée
            return response()->json(['attributeLang' => $attributeLang], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la création de la langue attribut.'], 500);
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
                'lib' => 'required|string',
                'lang_id' => 'required|integer|exists:langs,id',
                'attribute_id' => 'required|integer|exists:attributes,id',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Récupérer la langue attribut spécifiée par son ID
            $attributeLang = AttributeLang::findOrFail($id);

            // Mettre à jour les attributs de la langue attribut avec les nouvelles données JSON
            $attributeLang->update($request->json()->all());

            // Retourner une réponse JSON avec un message de succès
            return response()->json(['message' => 'Langue attribut mise à jour avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour de la langue attribut.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            // Récupérer la langue attribut spécifiée par son ID
            $attributeLang = AttributeLang::findOrFail($id);
            
            // Supprimer la langue attribut
            $attributeLang->delete();
            
            // Retourner une réponse JSON avec un message de succès
            return response()->json(['message' => 'Langue attribut supprimée avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression de la langue attribut.'], 500);
        }
    }
}
