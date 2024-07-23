<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table_erreur;
use Maatwebsite\Excel\Facades\Excel;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;
use Log;

class Import_controller extends Controller
{
    public function to_importEtapeResult(){
        return view('import.etape_result');
    }

    public function to_importPoints(){
        return view('import.import_points');
    }

    /*public function importEtapeResult(Request $request){
        // Vérifie si un fichier CSV a été téléchargé
        if ($request->hasFile('csv_etape') && $request->hasFile('csv_result')) {
            // Déplace le fichier vers un emplacement temporaire sur le serveur
            $path1 = $request->file('csv_etape')->storeAs('csv_etape', 'csv_etape.csv');
            $path2 = $request->file('csv_result')->storeAs('csv_result', 'csv_result.csv');

            // Chemin complet vers le fichier CSV temporaire
            $filePath1 = storage_path('app/' . $path1);
            $filePath2 = storage_path('app/' . $path2);

            // Insérer les données du fichier CSV dans la table temporaire
            $this->importEtapeResultTable($filePath1, $filePath2);

            // Redirection avec un message de succès
            return redirect()->back()->with('success', 'Le fichier CSV a été importé avec succès.');
        } else {
            // Redirection avec un message d'erreur si aucun fichier n'a été téléchargé
            return redirect()->back()->with('error', 'Veuillez sélectionner deux fichier CSV.');
        }
    }

    public function importEtapeResultTable($filePath_etape, $filePath_result) {
        $delimiter = ",";

        $nomTable1 = "etape_temp";
        $nomTable2 = "resultat_temp";

        // Créer les tables temporaires et importer les fichiers CSV
        $this->createTableTemp($filePath_etape, $delimiter, $nomTable1);
        $this->createTableTemp($filePath_result, $delimiter, $nomTable2);

        // Lire les données des tables temporaires
        $etape_temp = DB::table($nomTable1)->get();
        $result_temp = DB::table($nomTable2)->get();

        $temp_etape = [];
        $temp_result = [];

        DB::beginTransaction();

        // Parcourir les données de la table etape_temp
        foreach ($etape_temp as $row) {
            $temp_etape[] = [
                'etape' => trim($row->etape),
                'longueur' => str_replace(',', '.', trim($row->longueur)),
                'nb_coureur' => trim($row->nb_coureur),
                'rang' => trim($row->rang),
                'date_depart' => str_replace(' ', '', trim($row->date_depart)),
                'heure_depart' => str_replace(' ', '', trim($row->heure_depart)),
                'ligne' => $row->ligne
            ];
        }

        // Parcourir les données de la table resultat_temp
        foreach ($result_temp as $row) {
            $temp_result[] = [
                'etape_rang' => trim($row->etape_rang),
                'numero_dossard' => trim($row->numero_dossard),
                'nom' => trim($row->nom),
                'genre' => trim($row->genre),
                'date_naissance' => str_replace(' ', '', trim($row->date_naissance)),
                'equipe' => trim($row->equipe),
                'arrivee' => trim($row->arrivee),
                'ligne' => $row->ligne
            ];
        }

        DB::table('etape_temp')->insert($temp_etape);
        DB::table('resultat_temp')->insert($temp_result);

        DB::statement('SELECT verify_etape();');
        $tableErreur = DB::table('table_erreur')->get();

        if (count($tableErreur) > 0) {
            DB::table('table_erreur')->delete();
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreurs dans les données d\'étape.');
        } else {
            DB::statement('SELECT insert_etape();');
            DB::statement('SELECT verify_resultat();');

            $tableErreur = DB::table('table_erreur')->get();

            if (count($tableErreur) > 0) {
                DB::table('etape_temp')->delete();
                DB::table('table_erreur')->delete();
                DB::rollBack();
                return redirect()->back()->with('error', 'Erreurs dans les données de résultat.');
            } else {
                DB::statement('SELECT insert_groupe();');
                DB::table('etape_temp')->delete();
                DB::table('resultat_temp')->delete();

                DB::commit();
                return redirect()->back()->with('success', 'Données importées avec succès.');
            }
        }
    }


    public function createTableTemp($filePath, $delimiter, $nomTableCSV) {
        $handle = fopen($filePath, 'r');
        $col = fgetcsv($handle);

        // Supprime la table si elle existe
        DB::statement("DROP TABLE IF EXISTS " . $nomTableCSV . ";");

        // Ajouter une colonne 'ligne' de type SERIAL
        $queryCol = ["ligne SERIAL"];
        foreach ($col as $NomCol) {
            // Remplacer les espaces par des underscores pour les noms de colonnes
            $cleanedCol = str_replace(' ', '_', $NomCol);
            $queryCol[] = $cleanedCol . " VARCHAR(100)";
        }

        // Requête pour créer la table
        $queryTable = "CREATE TABLE " . $nomTableCSV . " (" . implode(",", $queryCol) . ");";
        DB::statement($queryTable);

        // Requête pour insérer les données dans la table
        $queryInsert = "COPY " . $nomTableCSV . " (" . implode(",", array_map(fn($col) => str_replace(' ', '_', $col), $col)) . ") FROM '" . $filePath . "' DELIMITER '" . $delimiter . "' CSV HEADER;";
        DB::statement($queryInsert);

        fclose($handle);
    }*/


    // daaannn
    public function importEtapesResultats(Request $request)
    {
        // Validation des fichiers CSV
        $request->validate([
            'csv_file1' => 'required|mimes:csv,txt,xlsx',
            'csv_file2' => 'required|mimes:csv,txt,xlsx'
        ]);

        $file1 = $request->file('csv_file1');
        $file2 = $request->file('csv_file2');

        // Lire le fichier 1
        $csv1 = Reader::createFromPath($file1->getRealPath(), 'r');
        $csv1->setHeaderOffset(0);

        // Insérer les données du fichier 1 directement

        foreach ($csv1 as $record) {
            // Traitement des données ici pour le fichier 1
            $data = [
                "etape" => trim($record['etape']),
                "longueur" => trim(str_replace(',', '.', $record['longueur'])),
                "nb_coureur" => trim($record['nb coureur']),
                "rang" => trim($record['rang']),
                "date_depart" => trim(str_replace(' ', '', $record['date départ'])),
                "heure_depart" => trim(str_replace(' ', '', $record['heure départ']))
            ];
            // Insérer les données directement dans la table correspondante
            DB::table('etape_temp')->insert($data);
        }

        // Lire le fichier 2
        $csv2 = Reader::createFromPath($file2->getRealPath(), 'r');
        $csv2->setHeaderOffset(0);

        // Insérer les données du fichier 2 directement
        foreach ($csv2 as $record) {
            // Traitement des données ici pour le fichier 2
            $data = [
                "etape_rang" => trim($record['etape_rang']),
                "numero_dossard" => trim($record['numero dossard']),
                "nom" => trim($record['nom']),
                "genre" => trim($record['genre']),
                "date_naissance" => trim(str_replace(' ', '', $record['date naissance'])),
                "equipe" => trim($record['equipe']),
                "arrivee" => trim($record['arrivée'])
            ];
            DB::table('resultat_temp')->insert($data);
        }

        DB::beginTransaction();

        // // Vérifier et insérer les étapes
        DB::statement('DELETE FROM table_erreur');
        DB::statement('SELECT verify_etape()');
        $errors = DB::table('table_erreur')->get();

        if ($errors->isNotEmpty()) {
            DB::statement('DELETE FROM table_erreur');
            DB::statement('DELETE FROM etape_temp');
            DB::statement('ALTER SEQUENCE etape_temp_ligne_seq restart with 1');
            DB::statement('DELETE FROM resultat_temp ');
            DB::statement('ALTER SEQUENCE resultat_temp_ligne_seq restart with 1');
            DB::commit();
            //return redirect()->back()->with('error', $errors);
            return view('error.affiche_error', compact('errors'));
        }
        else {
            DB::statement('SELECT insert_etape()');
            //Vérifier et insérer les résultats
            DB::statement('SELECT verify_resultat()');

            $errors = DB::table('table_erreur')->get();
            if ($errors->isNotEmpty()) {
                DB::rollBack();
                DB::statement('DELETE FROM table_erreur');
                DB::statement('DELETE FROM etape_temp');
                DB::statement('ALTER SEQUENCE etape_temp_ligne_seq restart with 1');
                DB::statement('DELETE FROM resultat_temp ');
                DB::statement('ALTER SEQUENCE resultat_temp_ligne_seq restart with 1');
                DB::commit();
                return view('error.affiche_error', compact('errors'));
                //return redirect()->back()->with('error', $errors);
            }
            else{
                DB::statement('SELECT insert_groupe()');
                // Commit de la transaction
                DB::statement('DELETE FROM etape_temp');
                DB::statement('ALTER SEQUENCE etape_temp_ligne_seq restart with 1');
                DB::statement('DELETE FROM resultat_temp ');
                DB::statement('ALTER SEQUENCE resultat_temp_ligne_seq restart with 1');
                DB::commit();
            }
        }

        return redirect()->back()->with('success', 'C est fait l\'importation des données CSV.');
    }

    public function importPoints(Request $request)
    {
        // Validation des fichiers CSV
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt,xlsx'
        ]);

        $file1 = $request->file('csv_file');
        $csv1 = Reader::createFromPath($file1->getRealPath(), 'r');
        $csv1->setHeaderOffset(0);

        // Insérer les données du fichier 1 directement

        foreach ($csv1 as $record) {
            // Traitement des données ici pour le fichier 1
            $data = [
                "classement" => trim($record['classement']),
                "points" => trim(str_replace(',', '.', $record['points']))
            ];

            DB::table('point_temp')->insert($data);
        }

        DB::beginTransaction();

        // // Vérifier et insérer les étapes
        DB::statement('DELETE FROM table_erreur');
        DB::statement('SELECT verify_rang()');

        $errors = DB::table('table_erreur')->get();
        if ($errors->isNotEmpty()) {
            //return view('admin.import.importEtapeResultats', ['error' => $errors]);
            DB::statement('DELETE FROM table_erreur');
            DB::statement('DELETE FROM point_temp ');
            DB::statement('ALTER SEQUENCE point_temp_ligne_seq restart with 1');
            DB::commit();
            return view('error.affiche_error', compact('errors'));
        }
        else {
            DB::statement('SELECT insert_rang()');
            DB::statement('DELETE FROM point_temp ');
            DB::statement('ALTER SEQUENCE point_temp_ligne_seq restart with 1');
            DB::commit();
        }

        return redirect()->back()->with('success', 'C est fait l\'importation des données CSV.');
    }


   /* public function importPoints(Request $request)
    {
        // Validation des fichiers CSV
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt,xlsx'
        ]);

        $file = $request->file('csv_file');

        // Début de la transaction
        DB::beginTransaction();

        try {
            // Si le fichier est présent
            if ($file) {
                // Lire le fichier
                $csv = Reader::createFromPath($file->getRealPath(), 'r');
                $csv->setHeaderOffset(0);

                // Insérer les données directement depuis le CSV
                foreach ($csv as $record) {
                    // Traitement des données ici
                    $data = [
                        "classement" => trim($record['classement']),
                        "points" => trim($record['points'])
                    ];

                    // Insérer les données directement dans la table correspondante
                    DB::table('point_temp')->insert($data);
                }

                // Vérifier et insérer les rangs
                DB::statement('SELECT verify_rang()');
                $errors = DB::table('table_erreur')->get();

                if ($errors->isNotEmpty()) {
                    DB::rollBack();
                    return view('pages.resultimport', ['error' => $errors]);
                }

                DB::statement('SELECT insert_rang()');

                // Commit de la transaction
                DB::commit();

                // Suppression des tables temporaires
                DB::statement('TRUNCATE TABLE point_temp RESTART IDENTITY');

                return view('pages.resultimport', ['success' => 'Les points ont été importés avec succès.']);
            }

            return redirect()->back()->with('error', 'Aucun fichier sélectionné.');

        } catch (\Exception $e) {
            // Rollback de la transaction en cas d'erreur
            DB::rollBack();
            Log::error('Erreur lors de l\'importation des données CSV : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'importation des données CSV.');
        }
    } */


}
