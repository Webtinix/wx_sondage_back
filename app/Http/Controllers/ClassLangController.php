<?php

namespace App\Http\Controllers;

use App\Models\ClassLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class ClassLangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get($id = null)
    {
        try {
            if ($id != null) {
                # code...
                $classLang = ClassLang::findOrFail($id);
                // Retourner une réponse JSON avec les détails de la langue de classe
                return response()->json(['classLang' => $classLang]);
            }
            // Récupérer toutes les instances de la ressource ClassLang
            $classLangs = ClassLang::all();
            
            // Retourner une réponse JSON avec les langues de classe récupérées
            return response()->json(["classLangs" => $classLangs]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des langues de classe.'], 500);
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
                'classe_id' => 'required|integer|exists:classes,id',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Créer une nouvelle instance de la langue de classe
            $classLang = ClassLang::create($request->json()->all());

            // Retourner une réponse JSON avec la langue de classe créée
            return response()->json(['classLang' => $classLang], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la création de la langue de classe.'], 500);
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
                'classe_id' => 'required|integer|exists:classes,id',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Récupérer la langue de classe spécifiée par son ID
            $classLang = ClassLang::findOrFail($id);

            // Mettre à jour les attributs de la langue de classe avec les nouvelles données JSON
            $classLang->update($request->json()->all());

            // Retourner une réponse JSON avec un message de succès
            return response()->json(['message' => 'Langue de classe mise à jour avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour de la langue de classe.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            // Récupérer la langue de classe spécifiée par son ID
            $classLang = ClassLang::findOrFail($id);
            
            // Supprimer la langue de classe
            $classLang->delete();
            
            // Retourner une réponse JSON avec un message de succès
            return response()->json(['message' => 'Langue de classe supprimée avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression de la langue de classe.'], 500);
        }
    }
}
