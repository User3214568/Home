<?php

use App\Http\Controllers\EtudiantController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//URL::forceScheme('https');
Route::post('/login', 'UserController@login')->name('login');



Route::get('/', 'MainController@index')->name('home');
Route::get('/login', 'MainController@login');
Route::get('/restore-password', 'MainController@restorePassword');
Route::post('/restore-password', 'MainController@sendRestorePassword');
Route::get('/login/{token}', 'MainController@loginWithToken');

Route::middleware((['auth', 'type:0']))->group(function () {
    Route::get('admin/etudiant/resultats', 'EtudiantController@results')->name('etudiant.result');
    Route::get('/admin/etudiant/evaluation', 'EtudiantController@evaluation')->name('etudiant.evaluation');
    Route::post('/admin/formation/notes', 'FormationController@notes')->name('formation.notes');

    Route::post('/admin/finance/import/formation', 'UploadController@importPaiementEtudiant')->name('finance.import.versement');


    Route::get('/admin/finance/export/{id}-{type}', 'UploadController@exportFinanceFormation')->name('finance.export.formation');

    #Export Resultat Modules---------------------------------------------------------------------------------------------------------------
    Route::get('/admin/etudiant/export/resultat-modules/{promotion_id}-{session}-{module_id}', 'UploadController@exportResultats')->name('export.resultat.modules');
    #---------------------------------------------------------------------------------------------------------------------------------------

    #Delibration ---------------------------------------------------------------------------------------------------
    Route::get('/admin/etudiant/delibration', "EtudiantController@delibration")->name('etudiant.delibration');
    Route::get('/admin/formation/delibration/{formation_id}', "FormationController@delibration")->name('formation.delibration');

    #---------------------------------------------------------------------------------------------------


    #EXPORT-Import PROFESSEURS------------------------------------------------------------
    Route::post('/admin/professeur/import/{id}', 'UploadController@importProfesseurs')->name('professeur.import');
    Route::get('/admin/professeur/export/{id}-{type}', 'UploadController@exportProfesseur')->name('professeur.export');
    Route::get('/admin/professeur/history','ProfesseurController@history')->name('professeur.history');
    #------------------------------------------------------------------------------
    Route::get('/admin/formation/modules/{id}', 'FormationController@getModules')->name('formation.modules');
    Route::get('/admin/formation/professeurs/{id}', 'FormationController@getProfesseurs')->name('formation.professeurs');

    #----------EXPORT IMPORT PAIEMENT DU PROF-----------------------
    Route::get('/admin/finance/export/paiement/{id}-{type}', 'UploadController@exportFormationPaiement')->name('paiement.export');
    Route::post('/admin/finance/import/paiement/{id}', 'UploadController@importProfPaiement')->name('paiement.import');
    #------------------------------------------------------------


    #--------------------ETUDIANT IMPORT EXPORT------------------------------------
    Route::post('/admin/etudiant/import/{id}', 'UploadController@importEtudiants')->name('etudiant.import');
    Route::get('/admin/etudiant/export/{id}-{type}', 'UploadController@exportEtudiants')->name('etudiant.export');
    #--------------------------------------------------------------------------------

    #---------------------DEPENSES EXPORT IMPORT------------------------------
    Route::get('/admin/finance/depense/export/{type}', 'UploadController@exportDepenses')->name('depense.export');
    Route::post('/admin/finance/depense/import', 'UploadController@importDepenses')->name('depense.import');

    #--------------------------------------------------------------------------------

    #------------------TEACHER import export routes ----------------------------------------
    Route::get('/admin/teacher/export-{type}','UploadController@exportTeachers')->name('teacher.export');
    Route::post('/admin/teacher/import','UploadController@importTeachers')->name('teacher.import');
    #-----------------------------------------------------------------------


    #----------------------------------------------------------------
    #----------------------------------END OF YEAR-----------------------------------------
    Route::post('/admin/etudiant/find-annee', 'EtudiantController@finAnnee')->name('etudiant.finaliser');
    #-------------------------------------------------------------------------------

    #-------------------------------------OLD------------------
    Route::get('/admin/history', 'HistoryController@index')->name('history.index');
    #--------------------------------------------------------------------
    #---------------------------------LAUREAT--------------------------
    Route::get('/admin/formation/laureats','FormationController@laureat')->name('formations.laureat');
    #-----------------------------------------------------------------

    Route::resource('/admin/teacher', 'TeacherController');
    Route::resource('/admin/finance/depense', 'DepensesController');
    Route::resource('/admin/professeur', 'ProfesseurController');
    Route::resource('/admin/finance/paiement', 'PaiementController');
    Route::resource('/admin/finance/tranche', 'TrancheController');
    Route::resource('/admin/formation', 'FormationController');
    Route::resource('/admin/module', 'ModuleController');
    Route::resource('/admin/etudiant', 'EtudiantController');
    Route::post('/admin/import-module-note/{sem_id}-{module_id}-{session}', 'UploadController@importNoteModule')->name('etudiant.notes.import');
    Route::get('/admin/export-module-notes/{sem_id}-{module_id}-{session}-{type}', 'UploadController@exportModule')->name('etudiant.notes.module.export');
    Route::get('/admin/export-notes/{id}', 'UploadController@exportnotes')->name('etudiant.notes.export');
    Route::get('/admin/export-all-formations', 'UploadController@exportAllFormations')->name('exportallformations');
    Route::get('/admin', 'MainController@admin')->name('admin');
});


Route::middleware(['auth','limitation'])->group(function () {
    Route::get('/logout', 'UserController@logout')->name('logout');
    Route::get('/users/avatars/{cin}', 'PrivateImagesController@getImage')->name('avatar');
    Route::resource('/admin/user', 'UserController');
    #----------------------------NOTES UPDATE------------------------------
    Route::post('/admin/etudiant/update-note', 'EtudiantController@notesUpdate')->name('etudiant.note.update');
    #----------------------------NOTES COMMIT------------------------------
    Route::get('admin/Module/commit/{promotion_id}-{sem_id}-{module_id}', 'ModuleController@commitOrdinaireSession')->name('module.commit.notes');
    #----------------------------- notes section----------------------------
    Route::get('/admin/etudiant/request-notes/{result}-{promotion}-{semestre}-{module}-{session}', 'EtudiantController@requestNotes');

    #------------------------------NOTES IMPORT EXPORT--------------------------
    Route::post('/admin/import-module-note/{sem_id}-{module_id}-{session}', 'UploadController@importNoteModule')->name('etudiant.notes.import');
    Route::get('/admin/export-module-notes/{sem_id}-{module_id}-{session}-{type}', 'UploadController@exportModule')->name('etudiant.notes.module.export');
});

Route::middleware((['auth', 'type:1']))->group(function () {
    Route::get('/enseignant', 'TeacherController@homepage')->name('enseignant.index');
    Route::get('/enseignant/notes', 'TeacherController@teacherNotes')->name('enseignant.notes');
    Route::get('/enseignant/paiements','TeacherController@paiements')->name('enseignant.paiements');
});

Route::middleware((['auth','type:2']))->group(function(){
    Route::get('/etudiant','EtudiantController@homepage')->name('etudiant.home');
    Route::get('/etudiant/results','EtudiantController@resultsPage')->name('etudiant.resultspage');
    Route::get('etudiant/versements','etudiantController@versements')->name('etudiant.versements');
});
