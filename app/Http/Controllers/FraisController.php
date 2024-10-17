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
    public function getFraisVisiteur()
    {
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

    public function updateFrais($id_frais)
    {
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

    public function validateFrais(Request $request)
    {
        $erreur = "";
        try {
            $id_frais = $request->input('id_frais');
            $anneemois = $request->input('anneemois');
            $nbjustificatifs = $request->input('nbjustificatifs');
            $serviceFrais = new ServiceFrais();
            if ($id_frais > 0) {
                $serviceFrais->updateFrais($id_frais, $anneemois, $nbjustificatifs);
            } else {
                $idVisiteur = Session::get('id');
                $serviceFrais -> insertFrais($idVisiteur,$id_frais,$anneemois,$nbjustificatifs);
            }
            return redirect('/listeFrais');
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }

    public function addFrais()
    {
        try {
            $unFrais = new Frais();
            $unFrais->id_frais = 0;
            $titreVue = "Création d'une fiche de frais";
            return view('formFrais', ['unFrais' => $unFrais, 'titreVue' => $titreVue]);
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }


    }



//    public function modifierFrais($id_frais,$anneemois,$nbjustificatifs,)
//    {
//        try {
//            DB::table('frais')
//                ->where('id_frais',$id_frais)
//                ->update([
//                    'id_frais' => $id_frais,
//                    'anneemois' => $anneemois,
//                    'nbjustificatifs' => $nbjustificatifs,
//                ]);
//        } catch (\Illuminate\Database\QueryException $e) {
//            throw new MonException($e->getMessage(), 5);
//        }
//    }




}
