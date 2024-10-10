<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\dao\ServiceFrais;
use Exception;

class FraisController extends Controller
{
    /**
     * Affiche la liste des frais du visiteur connecté
     * Retourne la vue listeFrais
     */
    public function getFraisVisiteur() {
        $erreur = "";
        try {
            $id = Session::get('id');  // Récupérer l'ID du visiteur connecté
            $serviceFrais = new ServiceFrais();
            $mesFrais = $serviceFrais->getFrais($id);
            return view('vues/listeFrais', compact('mesFrais', 'erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }
    public function updateFrais($id_frais) {
        $erreur = "";
        try {
            $serviceFrais = new ServiceFrais();
            $unFrais = $serviceFrais->getById($id_frais);
            $titreVue = "Modification d'une fiche de frais";
            return view('vues/formFrais', compact('unFrais', 'titreVue'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }
    public function validateFrais(Request $request) {
        $erreur = "";
        try {
            $id_frais = $request->input('idfrais');
            $anneemois = $request->input('anneemois');
            $nbjustificatifs = $request->input('nbjustificatifs');

            if ($id_frais > 0) {
                $serviceFrais = new ServiceFrais();
                $serviceFrais->updateFrais($id_frais, $anneemois, $nbjustificatifs);
            }
            return redirect('/getListeFrais');
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }



}
