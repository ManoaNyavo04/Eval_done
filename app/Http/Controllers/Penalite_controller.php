<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etape;
use App\Models\Equipe;
use App\Models\V_penalite_ajouter;
use App\Models\Penalite;
use DateTime;

class Penalite_controller extends Controller
{
    public function toListePenalite(){
        $etapes = Etape::all();
        $equipes = Equipe::all();
        $penalites = V_penalite_ajouter::all();

        return view('admin.penalite.crud_penalite', compact('etapes', 'equipes', 'penalites'));
    }

    public function deletePenalite($id_etape, $id_equipe){
        $penalite = Penalite::where('id_etape', $id_etape)
            ->where('id_equipe', $id_equipe)
            ->first();

        if ($penalite) {
            $penalite->delete();
            //return redirect()->route('produit.all_formule')->with('success', 'La formule a été supprimée avec succès');
            return redirect()->back()->with('success', ' penalité  supprimée avec succès');

        } else {
           return redirect()->back()->with('error', 'La penalité n\'a pas été trouvée');
          //return 'non supprimé' ;
        }
    }

    public function insertPenalite(Request $request){
        $id_etape = $request->input('id_etape');
        $id_equipe = $request->input('id_equipe');
        $temps = $request->input('temps');

        $penalites = new Penalite();
        $penalites->id_etape = $id_etape;
        $penalites->id_equipe = $id_equipe;
        if ($temps instanceof DateTime) {
            $penalites->heure_penalite = $temps->format('Y-m-d H:i:s');
        } else {
            try {
                // Essayez de créer un objet DateTime à partir de $temps
                $dateTime = new DateTime($temps);
                $penalites->heure_penalite = $dateTime->format('Y-m-d H:i:s');
            } catch (Exception $e) {
                // Gérez l'erreur si la conversion échoue
                return back()->with('error', 'Le format de la date est incorrect.');
            }
        }
        $penalites->save();

        return redirect()->back()->with('success', 'Les heures ont été ajoutées avec succès.');
    }
}
