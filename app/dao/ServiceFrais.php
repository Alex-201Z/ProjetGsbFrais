<?php

namespace App\dao;

use App\Models\Frais;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Exceptions\MonException;

class ServiceFrais
{
    public function getFrais($id_visiteur) {
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
    public function getById($id_frais) {
        try {
            $unFrais = DB::table('frais')
                ->where('id_frais', '=', $id_frais)
                ->first();
            return $unFrais;
        } catch (QueryException $e) {
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



}

