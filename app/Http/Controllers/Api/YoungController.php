<?php

namespace App\Http\Controllers\Api;

use App\Models\Young;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class YoungController extends Controller
{
    /**
     * Affiche la liste des jeunes.
     */
    public function index(): JsonResponse
    {
        $youngs = Young::all();

        return response()->json([
            'message' => 'Liste des jeunes',
            'data' => $youngs
        ]);
    }

    

    /**
     * Ajoute un nouveau jeune.
     */
    

public function store(Request $request): JsonResponse
    {
        try {
            // Validation initiale sans les documents
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'birth_date' => 'required|date',
                'id_card_number' => 'nullable|string|max:20',
                'is_elector' => 'required|boolean',
                'phone' => 'required|string|max:15',
                'email' => 'required|email|unique:youngs,email',
                'address' => 'required|array',
                'address.region' => 'required|string|max:255',
                'address.department' => 'required|string|max:255',
                'address.commune' => 'required|string|max:255',
                'address.quartier' => 'required|string|max:255',
            ]);

            // Traitement des fichiers
            $documents = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    // Stocker directement dans le dossier public/documents
                    $path = $file->storeAs('documents', $fileName, 'public');
                    if ($path) {
                        $documents[] = $path;
                    }
                }
            }

            // Préparation des données pour la création
            $youngData = $validatedData;
            $youngData['documents'] = $documents;

            // Création de l'enregistrement
            $young = Young::create($youngData);

            return response()->json([
                'message' => 'Jeune ajouté avec succès',
                'data' => $young,
            ], 201);

        } catch (\Throwable $th) {
            Log::error('Erreur lors de l\'ajout:', [
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Erreur lors de l\'ajout',
                'errors' => $th->getMessage(),
            ], 422);
        }
    }
    /**
     * Met à jour les informations d'un jeune existant.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $young = YouSearchng::find($id);

        if (!$young) {
            return response()->json(['message' => 'Jeune non trouvé'], 404);
        }

        $validatedData = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'birth_date' => 'sometimes|date',
            'id_card_number' => 'nullable|string|max:20',
            'is_elector' => 'sometimes|boolean',
            'phone' => 'sometimes|string|max:15',
            'email' => 'sometimes|email|unique:youngs,email,' . $young->id,
            'address' => 'sometimes|array',
            'documents' => 'array',
            'admin_id' => 'sometimes|exists:admins,id',
        ]);

        $young->update($validatedData);

        return response()->json([
            'message' => 'Jeune mis à jour avec succès',
            'data' => $young
        ]);
    }

    /**
     * Supprime un jeune.
     */
    public function destroy($id): JsonResponse
    {
        $young = Young::find($id);

        if (!$young) {
            return response()->json(['message' => 'Jeune non trouvé'], 404);
        }

        $young->delete();

        return response()->json(['message' => 'Jeune supprimé avec succès']);
    }
}
