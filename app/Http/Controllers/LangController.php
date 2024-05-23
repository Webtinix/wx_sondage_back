<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class LangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get($id = null)
    {
        try {
            if ($id != null) {
                # code...
                // Récupérer la langue spécifiée par son ID
                $lang = Lang::findOrFail($id);
                return response()->json(['langs' => $lang]);
            }
            // Récupérer toutes les instances de la ressource Lang
            $langs = Lang::all();
            
            // Retourner une réponse JSON avec les langues récupérées
            return response()->json(['langs' => $langs]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des langues.'], 500);
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
                'iso' => 'required|string',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Créer une nouvelle instance de la langue
            $lang = Lang::create($request->json()->all());

            // Retourner une réponse JSON avec la langue créée
            return response()->json(['message' => 'Langue créée avec succès.'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la création de la langue.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Valider les données JSON de la requête
            $validator = Validator::make($request->json()->all(), [
                'lib' => 'required|string',
                'iso' => 'required|string',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Récupérer la langue spécifiée par son ID
            $lang = Lang::findOrFail($id);

            // Mettre à jour les attributs de la langue avec les nouvelles données JSON
            $lang->update($request->json()->all());

            // Retourner une réponse JSON avec un message de succès
            return response()->json(['message' => 'Langue mise à jour avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour de la langue.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            // Récupérer la langue spécifiée par son ID
            $lang = Lang::findOrFail($id);
            
            // Supprimer la langue
            $lang->delete();
            
            // Retourner une réponse JSON avec un message de succès
            return response()->json(['message' => 'Langue supprimée avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression de la langue.'], 500);
        }
    }
}
