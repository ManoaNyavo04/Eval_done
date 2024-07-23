<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etape;
use App\Models\V_classement_etape;
use App\Models\V_classement_equipe;
use App\Models\Categorie;
use App\Models\Classement_categorie;
use Illuminate\Support\Facades\DB;
use App\Models\V_classement_coureur_point;
use App\Models\V_etape_coefficient;

class Classement_controller extends Controller
{
    public function getEtatClassement($userId){
        $etape = Etape::all();
        return view('equipe.classement_etape', compact('etape', 'userId'));
    }

    public function toListeClassmEtapeEquipe(Request $request, $userId){

        $etape = $request->input('etape');
        $query = V_classement_etape::where('id_etape', $etape)->get();

        return view('equipe.result_classement_etape', compact('query', 'userId'));
    }

    public function getClassmEquipe($userId){
        $query = V_classement_equipe::all();

        return view('equipe.result_classm_equipe', compact('query', 'userId'));
    }

    public function liste_categorie($userId){
        $categories = Categorie::all();
        return view('equipe.classement_categorie', compact('categories', 'userId'));
    }

    public function get_calssement(Request $request, $userId){
        $id_categorie= $request->input('idcategorie');

        $class = new Classement_categorie();
        $result= $class->getClassementCat($id_categorie);

        return view('equipe.result_classement_categorie', compact('result', 'userId'));
    }


    //admin
    public function getClassmEtapeAdmin(){
        $etape = Etape::all();
        return view('admin.choix_etape', compact('etape'));
    }

    // classement general par etape
    public function listeClassmEtapeAdmin(Request $request){
        $etape = $request->input('etape');
        $query = V_classement_etape::where('id_etape', $etape)->get();

        return view('admin.liste_classm_etape', compact('query'));
    }

    // classement general equipe pour tout categorie
    public function listeClassmEquipeAdmin(){
        $query = V_classement_equipe::all();

        $result= collect($query);

        $labels = $result->pluck('nom')->toArray();
        $values = $result->pluck('points')->toArray();

        $data = [
            'labels' => $labels,
            'values' => $values
        ];

        return view('admin.result_classm_equipe', compact('query', 'data', 'labels', 'values'));
    }

    public function listeCatAdmin(){
        $categories = Categorie::all();
        return view('admin.classement_categorie.categorie', compact('categories'));
    }

    // classement generale ny equipe par categorie
    public function getClassmAdmin(Request $request){
        $id_categorie = $request->input('idcategorie');

        $class = new Classement_categorie();
        $resultat = $class->getClassementCat($id_categorie);

        $result = collect($resultat);

        $labels = $result->pluck('nom')->toArray();
        $values = $result->pluck('points')->toArray();

        $data = [
            'labels' => $labels,
            'values' => $values,
            'result' => $resultat // Ajoutez les résultats complets pour les afficher dans le tableau
        ];

        return response()->json($data);
    }


    // details points equipe par categorie
    public function getDetailsPointsEquipeParCategorie($id_categorie, $id_equipe){
        // $id_categorie= $request->input('id_categorie');
        // $id_equipe = $request->input('getDetailsPointsEquipeParCategorie');

        $class = new Classement_categorie();
        $resultat= $class->detailsPointEquipePaCategorie($id_categorie, $id_equipe);
        $result= collect($resultat);

        $sum_points= $result->sum('points');


        return view('admin.classement_categorie.details_points_par_equipe_par_cate', compact('result', 'sum_points'));
    }

    // jour 4 resultat general
    public function resultGeneral(){
        $etape = V_etape_coefficient::all();
        return view('admin.liste_etapeGenaral', compact('etape'));
    }

    public function getClassmGeneEtap(Request $request){
        $etape = $request->input('id_etape');
        $query = V_classement_coureur_point::where('id_etape', $etape)->get();

        return view('admin.resultatGeneralCoureur', compact('query'));
    }


}
