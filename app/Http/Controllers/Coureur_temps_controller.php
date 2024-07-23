<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Etape;
use App\Models\Coureur;
use App\Models\Coureur_temps;
use App\Models\V_coureur_etape;

class Coureur_temps_controller extends Controller
{
    public function getEtape(){
        $etape = Etape::all();
        return view('admin.liste_etape', compact('etape'));
    }

    public function getCoureurEtape(Request $request){
        $idetape = $request->input('id_etape');

        $coureur = V_coureur_etape::where('id_etape', $idetape)->get();

        return view('temps.insert_temps', compact('coureur', 'idetape'));
    }

    // mapiditra heure arrive satria mitovy daolo ny depart am etape iray
    public function insertCoureurTemps(Request $request){
        $request->validate([
            'etape' => 'required|exists:etape,id_etape',
            'coureur_ids' => 'required|array',
            'coureur_ids.*' => 'required|exists:coureur,id_coureur',
            // 'departs' => 'array',
            // 'departs.*' => 'nullable|date',
            'arrives' => 'array',
            'arrives.*' => 'nullable|date',
        ]);

        $id_etape = $request->input('etape');
        $etape = Etape::where('id_etape', $id_etape)->first();
        $depart = $etape->heure_depart;

        foreach ($request->input('coureur_ids') as $coureur_id) {
            // $depart = $request->input("departs.$coureur_id");

            $arrive = $request->input("arrives.$coureur_id");

            // Vérifiez si les deux heures sont fournies
            if ($depart && $arrive) {
                $depart = Carbon::parse($depart);
                $arrive = Carbon::parse($arrive);

                // Vérifiez si l'heure de départ et d'arrivée sont les mêmes
                if ($depart->equalTo($arrive)) {
                    $erreur = "Erreur: l'heure de départ et d'arrivée pour le coureur ID $coureur_id sont les mêmes";
                    return redirect()->back()->with('error', $erreur);
                }

                // Ajoutez un jour à $arrive si nécessaire
                if ($arrive->lt($depart)) {
                    $arrive->addDay();
                }

                // Calcul de la durée totale en heures
                $interval = $arrive->diff($depart);

                // Construction de la chaîne de formatage
                $formattedDuration = $interval->format('%ad %H:%I:%S');

                // Insertion dans la base de données
                Coureur_temps::create([
                    'id_etape' => $request->input('etape'),
                    'id_coureur' => $coureur_id,
                    'heure_depart' => $depart,
                    'heure_arrivee' => $arrive,
                    'duree' => $formattedDuration // Utilisation de la durée formatée
                ]);
            }
        }

        return redirect()->back()->with('success', 'Temps de coureurs insérés avec succès.');
    }

    // mapiditra heure depart am input
    /*public function insertCoureurTemps(Request $request){
        $request->validate([
            'etape' => 'required|exists:etape,id_etape',
            'coureur_ids' => 'required|array',
            'coureur_ids.*' => 'required|exists:coureur,id_coureur',
            'departs' => 'array',
            'departs.*' => 'nullable|date',
            'arrives' => 'array',
            'arrives.*' => 'nullable|date',
        ]);

        foreach ($request->input('coureur_ids') as $coureur_id) {
            $depart = $request->input("departs.$coureur_id");
            $arrive = $request->input("arrives.$coureur_id");

            // Vérifiez si les deux heures sont fournies
            if ($depart && $arrive) {
                $depart = Carbon::parse($depart);
                $arrive = Carbon::parse($arrive);

                // Vérifiez si l'heure de départ et d'arrivée sont les mêmes
                if ($depart->equalTo($arrive)) {
                    $erreur = "Erreur: l'heure de départ et d'arrivée pour le coureur ID $coureur_id sont les mêmes";
                    return redirect()->back()->with('error', $erreur);
                }

                // Ajoutez un jour à $arrive si nécessaire
                if ($arrive->lt($depart)) {
                    $arrive->addDay();
                }

                // Calcul de la durée totale en heures
                $interval = $arrive->diff($depart);

                // Construction de la chaîne de formatage
                $formattedDuration = $interval->format('%ad %H:%I:%S');

                // Insertion dans la base de données
                Coureur_temps::create([
                    'id_etape' => $request->input('etape'),
                    'id_coureur' => $coureur_id,
                    'heure_depart' => $depart,
                    'heure_arrivee' => $arrive,
                    'duree' => $formattedDuration // Utilisation de la durée formatée
                ]);
            }
        }

        return redirect()->back()->with('success', 'Temps de coureurs insérés avec succès.');
    }*/

    /*public function insertCoureurTemps(Request $request){
        $request->validate([
            'etape' => 'required|exists:etape,id_etape',
            'coureur_ids' => 'required|array',
            'coureur_ids.*' => 'required|exists:coureur,id_coureur',
            'departs' => 'required|array',
            'departs.*' => 'required|date',
            'arrives' => 'required|array',
            'arrives.*' => 'required|date',
        ]);

        foreach ($request->input('coureur_ids') as $coureur_id) {
            $depart = Carbon::parse($request->input("departs.$coureur_id"));
            $arrive = Carbon::parse($request->input("arrives.$coureur_id"));

            // Vérifiez si l'heure de départ et d'arrivée sont les mêmes
            if ($depart->equalTo($arrive)) {
                $erreur = "Erreur: l'heure de départ et d'arrivée pour le coureur ID $coureur_id sont les mêmes";
                return redirect()->back()->with('error', $erreur);
            }

            if ($arrive<$depart) {
                $arrive->modify('+1 day');
            }

            $duree = $arrive->diffAsCarbonInterval($depart);

            // Insertion dans la base de données
            Coureur_temps::create([
                'id_etape' => $request->input('etape'),
                'id_coureur' => $coureur_id,
                'heure_depart' => $depart,
                'heure_arrivee' => $arrive,
                'duree' => $duree->format('%H:%I:%S')
            ]);
        }

        return redirect()->back()->with('success', 'Temps de coureurs insérés avec succès.');
    } */


    /*public function insertCoureurTemps(Request $request){
        $request->validate([
            'etape' => 'required|exists:etape,id_etape',
            'coureur' => 'required|exists:coureur,id_coureur',
            'depart'  => 'required|date',
            'arrive'  => 'required|date'
        ]);

        // Récupération des heures de départ et d'arrivée
        $depart = Carbon::parse($request->input('depart'));
        $arrive = Carbon::parse($request->input('arrive'));

        $duree = $arrive->diffAsCarbonInterval($depart);
        //dd($duree);


        if ($depart==$arrive) {
            $erreur = "Erreur: depart arrive sont meme";
            return redirect()->back()->with('error', $erreur);
        }

        // Insertion dans la base de données
        Coureur_temps::create([
            'id_etape' => $request->input('etape'),
            'id_coureur' => $request->input('coureur'),
            'heure_depart' => $depart,
            'heure_arrivee' => $arrive,
            'duree' => $duree->format('%H:%I:%S')
        ]);

        return redirect()->back()->with('success', 'Temps de coureur inséré avec succès.');

    } */

    // insertion a partir ny conversion heure en seconde :
    /*public function insertCoureurTemps(Request $request){
    // Validation des données d'entrée
    $request->validate([
        'etape' => 'required|exists:etape,id_etape',
        'coureur' => 'required|exists:coureur,id_coureur',
        'depart' => 'required|date',
        'arrive' => 'required|date|after:depart'
    ]);

    // Récupération des heures de départ et d'arrivée
    $depart = Carbon::parse($request->input('depart'));
    $arrive = Carbon::parse($request->input('arrive'));

    // Conversion des heures en secondes
    $departSeconds = $depart->timestamp;
    $arriveSeconds = $arrive->timestamp;

    // Calcul de la durée en secondes
    $dureeSeconds = $arriveSeconds - $departSeconds;

    // Conversion de la durée en hh:mm:ss
    $hours = floor($dureeSeconds / 3600);
    $minutes = floor(($dureeSeconds % 3600) / 60);
    $seconds = $dureeSeconds % 60;

    $dureeFormatted = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

    // Insertion dans la base de données
    CoureurTemps::create([
        'id_etape' => $request->input('etape'),
        'id_coureur' => $request->input('coureur'),
        'heure_depart' => $depart,
        'heure_arrivee' => $arrive,
        'duree' => $dureeFormatted // PostgreSQL acceptera le format hh:mm:ss pour INTERVAL
    ]);

    return redirect()->back()->with('success', 'Temps de coureur inséré avec succès.');
}*/
}
