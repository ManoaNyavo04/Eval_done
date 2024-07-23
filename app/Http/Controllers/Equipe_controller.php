<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etape;
use App\Models\Coureur;
use App\Models\Coureur_etape;
use App\Models\V_coureur_etape;
use Illuminate\Support\Facades\DB;

class Equipe_controller extends Controller
{
    public function getAllEtape($userId){
        $etape = Etape::all();
        return view('equipe.liste_etape', compact('etape', 'userId'));
    }

    public function to_insert_coureur($userId, Request $request)
    {
        $id_etape = $request->input('id_etape');

        $countCoureurEtape = V_coureur_etape::where('id_etape', $id_etape)
                                            ->where('id_equipe', $userId)
                                            ->count('id_coureur');

        $etape = Etape::where('id_etape', $id_etape)->first();
        $nbCoureurEtape = $etape->nb_coureur;

        if ($countCoureurEtape >= $nbCoureurEtape) {
            $error = "Le nombre de votre joueur dans cette etape est déjà $nbCoureurEtape";
            return redirect()->back()->withErrors([$id_etape => $error]);
        }

        $coureurEquip = Coureur::where('id_equipe', $userId)->get();
        return view('equipe.insert_coureur', compact('coureurEquip', 'userId', 'id_etape'));
    }


    public function insertCoureurEtape($userId, Request $request)
    {
        $id_etape = $request->input('etape');
        $id_coureur = $request->input('coureur');

        try {
            // Récupérer le nombre de coureurs déjà existants
            $countCoureur = DB::table('coureur_etape as ct')
                ->join('coureur', 'coureur.id_coureur', '=', 'ct.id_coureur')
                ->where('ct.id_etape', $id_etape)
                ->where('coureur.id_equipe', $userId)
                ->count('ct.id_coureur');

            // Récupérer le nombre maximum de coureurs par étape
            $nbCoureur = DB::table('etape')
                ->where('id_etape', $id_etape)
                ->value('nb_coureur');

            if ($countCoureur >= $nbCoureur) {
                $errorMessage = "Nombre de coureurs maximal atteint pour cette étape.";
                return redirect()->back()->with('error', $errorMessage);
            }

            // Insérer le nouveau coureur dans l'étape
            $coureurEtape = new Coureur_etape();
            $coureurEtape->id_etape = $id_etape;
            $coureurEtape->id_coureur = $id_coureur;
            $coureurEtape->save();

            return redirect()->back()->with('success', 'Coureur inséré avec succès.');
        } catch (\Exception $e) {
            // Gérer les erreurs et les exceptions
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    /*public function getEtapeEquipe($userId){
        $etape = Etape::all();
        $coureurEtapeEquipe = V_coureur_etape_equipe::where('id_equipe', $userId);

        return view('equipe.accueil_equipe', compact('etape', 'coureurEtapeEquipe', 'userId'));
    }*/

}
