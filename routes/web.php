<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Coureur_temps_controller;
use App\Http\Controllers\Authentification_controller;
use App\Http\Controllers\Equipe_controller;
use App\Http\Controllers\Classement_controller;
use App\Http\Controllers\Import_controller;
use App\Http\Controllers\Categorie_controller;
use App\Http\Controllers\ExportPdf_controller;
use App\Http\Controllers\Penalite_controller;
use App\Http\Controllers\Reinitialiser_controller;
use App\Http\Controllers\Details_point_controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login.equipe');
});

// reinitialise base
Route::get('/reinitialise/resetBase', [Reinitialiser_controller::class, 'resetBase'])->name('reinitialise.resetBase');

// auth
Route::get('/auth/to-login-admin', [Authentification_controller::class, 'to_login_admin'])->name('auth.to_login_admin');
Route::post('/auth/login-admin', [Authentification_controller::class, 'login_admin'])->name('auth.login_admin');
Route::post('/auth/login-equipe', [Authentification_controller::class, 'login_equipe'])->name('auth.login_equipe');
Route::get('/accueil-equipe', [Authentification_controller::class, 'to_accueil_equipe'])->name('accueil_equipe');

// etape
Route::get('/etape/to-liste-etape/{userId}', [Equipe_controller::class, 'getAllEtape'])->name('etape.to_liste_etape');
Route::get('/etape/to-insertion-coureur/{userId}', [Equipe_controller::class, 'to_insert_coureur'])->name('etape.to_insert_coureur');
Route::post('/etape/insertion-coureur-par-etape/{userId}', [Equipe_controller::class, 'insertCoureurEtape'])->name('etape.insertCoureurEtape');
Route::get('/etape/resultat-general', [Classement_controller::class, 'resultGeneral'])->name('etape.resultatGeneral');


// classement
Route::get('/classement/to-liste-de-classement-general-par-etape-par-equipe/{userId}', [Classement_controller::class, 'getEtatClassement'])->name('classement.toListeClassmEtapeEquipe');
Route::post('/classement/resultat-classement-general-par-etape/{userId}', [Classement_controller::class, 'toListeClassmEtapeEquipe'])->name('classement.resultClassmEtape');
Route::get('/classement/to-classement-general-par-equipe/{userId}', [Classement_controller::class, 'getClassmEquipe'])->name('classement.to_classmEquipe');
Route::get('/classement/to-classement-general-par-categorie/{userId}', [Classement_controller::class, 'liste_categorie'] )->name('classement.to_classmCategorie');
Route::get('/etape/liste-des-etapes', [Classement_controller::class, 'listeEtape'])->name('etape.listeEtape');
Route::post('/classement/avoir-les-classements/{userId}', [Classement_controller::class, 'get_calssement'])->name('classement.get_calssement');


// admin cote classement
Route::get('/classement/to-classement-general-par-etape', [Classement_controller::class, 'getClassmEtapeAdmin'])->name('classement.toClassmEtape');
Route::post('/classement/liste-des-classement-par-etape', [Classement_controller::class, 'listeClassmEtapeAdmin'])->name('classement.liste_classm_etape');
Route::get('/classement/to-classement-des-equipes', [Classement_controller::class, 'listeClassmEquipeAdmin'])->name('classement.toClassmEquipe');
Route::get('/classement/to-classemet-des-categories', [Classement_controller::class, 'listeCatAdmin'])->name('classement.toClassmCatAdmin');
Route::post('/classement/get-calssementAdmin', [Classement_controller::class, 'getClassmAdmin'])->name('classement.get_calssementAdmin');
Route::get('/classement/resulat-general-admin', [Classement_controller::class, 'getClassmGeneEtap'])->name('classement.resulatGeneralAdmin');
Route::get('/classement/details-points-des-equipes-par-categorie/{id_categorie}/{id_equipe}', [Classement_controller::class, 'getDetailsPointsEquipeParCategorie'])->name('classement.details_points_eq_cate');


// temps coureur
Route::get('/temps-coureur/to-insertion-temps-coureur', [Coureur_temps_controller::class, 'getCoureurEtape'])->name('temps_coureur.to_insert_temps');
Route::post('/temps-coureur/insertion-temps-du-coureur', [Coureur_temps_controller::class, 'insertCoureurTemps'])->name('temps_coureur.insertTempsCoureur');
Route::get('/temps-coureur/to-liste-des-etapes', [Coureur_temps_controller::class, 'getEtape'])->name('temps_coureur.to_liste_etape');


// inmport
Route::get('import/etape-result', [Import_controller::class, 'to_importEtapeResult'] )->name('import.etape_result');
Route::get('/import/to-points', [Import_controller::class, 'to_importPoints'])->name('import.to_points');
Route::post('/import/points', [Import_controller::class, 'importPoints'])->name('import.points');
Route::post('/import/importEtapeResult', [Import_controller::class, 'importEtapesResultats'])->name('import.importEtapeResult');

// categorie
Route::get('/categorie/to-liste-des-coureurs', [Categorie_controller::class, 'getCoureur'])->name('categorie.to_liste_coureur');
Route::get('/categorie/genereration-categorie', [Categorie_controller::class, 'genererCategorie'])->name('categorie.genererCategorie');
Route::get('/categorie/to-generation-categorie', [Categorie_controller::class, 'to_genererCategorieBouton'])->name('categorie.to_generateCate');
Route::post('/categorie/generation-categorie', [Categorie_controller::class, 'genererCategorieBouton'])->name('categorie.generateCate');


// pdf
Route::get('/pdf/liste-du-vainceur', [ExportPdf_controller::class, 'getVainqueur'])->name('pdf.to_vainceur');
Route::post('/pdf/exporter-certificat-vainceur', [ExportPdf_controller::class, 'exportPdf'])->name('pdf.export');

// penalite
Route::get('/penalite/to-liste-des-penalites', [Penalite_controller::class, 'toListePenalite'])->name('penalite.to_liste_penalite');
Route::get('/penalite/supprimer-penalite/{id_etape}/{id_equipe}', [Penalite_controller::class, 'deletePenalite'])->name('penalite.delete');
Route::post('/penalite/insertion-des-penalites', [Penalite_controller::class, 'insertPenalite'])->name('penalite.insertPenalite');


Route::get('/alea/detailPointEquipe', [Details_point_controller::class, 'getDetailsPoint'])->name('alea.detailPointEquipe');



// alea2
Route::get('/coeff/affiche', [Classement_controller::class, 'getcoeff'])->name('coeff.affiche');
