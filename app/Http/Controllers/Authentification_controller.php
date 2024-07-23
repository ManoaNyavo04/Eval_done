<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Equipe;
use Illuminate\Support\Facades\Session;
use App\Models\Etape;
use App\Models\V_coureur_etape_equipe;


class Authentification_controller extends Controller
{

    public function to_login_admin(){
        return view('login.admin');
    }

    public function login_admin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $admin = Admin::where('login', $credentials['email'])->first();

        if ($admin && $admin->password === $credentials['password']) {
            // Authentification réussie, stocker l'ID de l'étudiant en session
            Session::put('admin_id', $admin->id_admin);

            // Rediriger vers la page d'accueil
            return view('admin.accueil_admin');
        } else {
            // Échec de l'authentification
            return redirect()->back()->with('erreur', 'Identifiant invalide');
            //return back()->withErrors(['email' => 'Identifiants invalides']);
        }
    }

    public function login_equipe(Request $request){
        $credentials = $request->only('email', 'password');

        $equipe = Equipe::where('login', $credentials['email'])->first();

        if ($equipe && $equipe->password === $credentials['password']) {
            // Authentification réussie, stocker l'ID de l'étudiant en session
            Session::put('user_id', $equipe->id_equipe);

            // Rediriger vers la page d'accueil
            return redirect()->route('accueil_equipe');
        } else {
            // Échec de l'authentification
            return redirect()->back()->with('erreur', 'Identifiant invalide');
            //return back()->withErrors(['email' => 'Identifiants invalides']);
        }
    }

    public function to_accueil_equipe(){
        $userId = Session::get('user_id');

        // Récupérer toutes les étapes
        $etapes = Etape::all();

        // Récupérer les coureurs par étape pour l'équipe
        $coureurEtapeEquipe = V_coureur_etape_equipe::where('id_equipe', $userId)
        ->orderBy('id_etape')
        ->get()
        ->groupBy('id_etape');

        // var_dump($coureurEtapeEquipe):

        return view('equipe.accueil_equipe', compact('etapes', 'coureurEtapeEquipe', 'userId'));
    }

}
