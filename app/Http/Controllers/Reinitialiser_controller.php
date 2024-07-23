<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Reinitialiser_controller extends Controller
{
    public function resetBase(){
        try {
            DB::beginTransaction();

            // Exécuter la procédure de réinitialisation
            DB::statement('SELECT reset_tables()');

            DB::commit();

            return redirect()->back()->with('success', 'Les données ont été importées avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la réinitialisation des données.');
        }
    }

    public function valid_reinitialise($id_admin){

        try {
            DB::beginTransaction();

            // Exécuter la procédure de réinitialisation
            DB::statement('SELECT reset_tables()');

            DB::commit();

            return redirect()->back()->with('success', 'Les données ont été importées avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la réinitialisation des données.');
        }
    }

}
