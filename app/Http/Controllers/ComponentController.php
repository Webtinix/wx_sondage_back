<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get($id = null)
    {
        try {
            if ($id) {
                # code...
                $component = Component::findOrFail($id);
                return response()->json(["components" => $component]);
            }
            // Récupérer toutes les instances de la ressource Component
            $components = Component::all();
            
            // Retourner une réponse JSON avec les composants récupérés
            return response()->json(["components" => $components]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des composants.'], 500);
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
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Créer une nouvelle instance du composant
            $component = Component::create($request->json()->all());

            // Retourner une réponse JSON avec le composant créé
            return response()->json(['component' => $component], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la création du composant.'], 500);
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
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Récupérer le composant spécifié par son ID
            $component = Component::findOrFail($id);

            // Mettre à jour les attributs du composant avec les nouvelles données JSON
            $component->update($request->json()->all());

            // Retourner une réponse JSON avec un message de succès
            return response()->json(['message' => 'Composant mis à jour avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour du composant.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            // Récupérer le composant spécifié par son ID
            $component = Component::findOrFail($id);
            
            // Supprimer le composant
            $component->delete();
            
            // Retourner une réponse JSON avec un message de succès
            return response()->json(['message' => 'Composant supprimé avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression du composant.'], 500);
        }
    }
}
