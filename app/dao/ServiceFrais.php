<?php

namespace App\dao;

use App\Models\Frais;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Exceptions\MonException;

class ServiceFrais
{
    public function getFrais($id_visiteur)
    {
        try {
            $mesFrais = DB::table('frais')
                ->where('id_visiteur', '=', $id_visiteur)
                ->get();
            return $mesFrais;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    /**
     * Retourne la fiche de frais pour l'identifiant $id_frais
     */
    public function getById($id_Frais)
    {
        try {
            $unFrais = DB::table('frais')
                ->select()
                ->where('id_frais', '=', $id_Frais)
                ->first();
            return $unFrais;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function updateFrais($id_frais, $anneemois, $nbjustificatifs)
    {
        try {
            $aujourdhui = date("Y-m-d");
            DB::table('frais')
                ->where('id_frais', '=', $id_frais)
                ->update(['datemodification' => $aujourdhui,
                    'anneemois' => $anneemois,
                    'nbjustificatifs' => $nbjustificatifs
                ]);
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function addFrais()
    {
        try {
            $unFrais = new Frais();
            $unFrais->id_frais = 0; // Initialisation de l'ID pour un ajout
            $titreVue = "Ajout d'une fiche de frais";
            return view('vues/formFrais', compact('unFrais', 'titreVue'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }

    public function insertFrais($idVisiteur, $anneemois, $nbjustificatifs)
    {
        try {
            $aujourdhui = date("Y-m-d");
            DB::table('frais')
                ->insert(['datemodification' => $aujourdhui,
                    'id_etat' => 2,
                    'id_visiteur' => $idVisiteur,
                    'anneemois' => $anneemois,
                    'nbjustificatifs' => $nbjustificatifs],
                );

        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }
}

