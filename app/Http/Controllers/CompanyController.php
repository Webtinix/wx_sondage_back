<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get($id = null)
    {
        try {
            if ($id) {
                # code...
                $company = Company::findOrFail($id);
                return response()->json(["company" => $company]);
            }
            // Récupérer toutes les instances de la ressource Company
            $companies = Company::all();
            
            // Retourner une réponse JSON avec les entreprises récupérées
            return response()->json($companies);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des entreprises.'], 500);
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
                'uid' => 'required|string',
                'lib' => 'required|string',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Créer une nouvelle instance de l'entreprise
            $company = Company::create($request->json()->all());

            // Retourner une réponse JSON avec l'entreprise créée
            return response()->json(['company' => $company], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la création de l\'entreprise.'], 500);
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
                'uid' => 'required|string',
                'lib' => 'required|string',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Récupérer l'entreprise spécifiée par son ID
            $company = Company::findOrFail($id);

            // Mettre à jour les attributs de l'entreprise avec les nouvelles données JSON
            $company->update($request->json()->all());

            // Retourner une réponse JSON avec un message de succès
            return response()->json(['message' => 'Entreprise mise à jour avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour de l\'entreprise.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            // Récupérer l'entreprise spécifiée par son ID
            $company = Company::findOrFail($id);
            
            // Supprimer l'entreprise
            $company->delete();
            
            // Retourner une réponse JSON avec un message de succès
            return response()->json(['message' => 'Entreprise supprimée avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression de l\'entreprise.'], 500);
        }
    }
}
