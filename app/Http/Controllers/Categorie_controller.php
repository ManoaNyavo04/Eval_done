<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\V_coureur;
use App\Models\Categorie_coureur;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;

class Categorie_controller extends Controller
{
    public function getCoureur(){
        $coureurs = V_coureur::all();
        return view('categorie.liste_coureur', compact('coureurs'));
    }

    public function to_genererCategorieBouton(){
        return view('categorie.bouton_generer');
    }

    public function genererCategorieBouton(Request $request){
        DB::statement('SELECT insert_categorie_coureur()');
        return redirect()->back()->with('success', 'Categorie inserer et categorie coureur generer');
    }

    /*public function genererCategorie(Request $request){
        $id_coureur = $request->input('id_coureur');

        $categories = Categorie::all();
        $coureurs = V_coureur::where('id_coureur',  $id_coureur)->first();
        $ageCoureur = $coureurs->age;
        $idcoureur= $coureurs->id_coureur;
        $genre = $coureurs->genre;

        $categorieCour = new Categorie_coureur();

        foreach ($categories as $categorie) {
            $nomCategorie = $categorie->nom;
            if ($ageCoureur<18 && $genre===$nomCategorie) {
                $idcategorie=$categorie->id_categorie=1;

                $categorieCour->insertCategorieCoureur($idcategorie, $idcoureur);

                return "succees";
            }else if ($ageCoureur>18 && $genre===$nomCategorie) {
                $idcategorie=$categorie->id_categorie=2;

                $categorieCour->insertCategorieCoureur($idcategorie, $idcoureur);

                return "succees";
            }
        }

    } */


}
