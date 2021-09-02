<?php

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
Route::post('/login','UserController@login')->name('login');

Route::get('/','MainController@index')->name('home');
Route::get('/login','MainController@login');
Route::get('/restore-password','MainController@restorePassword');

Route::middleware(('auth'))->group(function(){

    Route::get('admin/Module/commit/{promotion_id}-{module_id}','ModuleController@commitOrdinaireSession')->name('module.commit.notes');
    Route::get('admin/etudiant/resultats','EtudiantController@results')->name('etudiant.result');
    Route::post('/admin/etudiant/update-note','EtudiantController@notesUpdate')->name('etudiant.note.update');
    Route::get('/admin/etudiant/evaluation','EtudiantController@evaluation')->name('etudiant.evaluation');
    Route::post('/admin/formation/notes','FormationController@notes')->name('formation.notes');

    Route::get('/admin/finance/ajouter-tranche','FinanceController@addTranche')->name('finance.add.tranche');
    Route::post('/admin/finance/ajouter-tranche','FinanceController@addTranchePost')->name('finance.add.tranch.post');
    Route::get('/admin/finance/ajouter-payement','FinanceController@addPayement')->name('finance.add.payement');
    Route::post('/admin/finance/ajouter-payement','FinanceController@storePayement')->name('finance.add.payement');


    Route::get('/admin/finance/payement-consultants','FinanceController@payementConsultants')->name('finance.payement.consultant');

    Route::resource('/admin/user','UserController');
    Route::resource('/admin/formation','FormationController');
    Route::resource('/admin/module','ModuleController');
    Route::resource('/admin/etudiant','EtudiantController');
    Route::post('/admin/upload','UploadController@import')->name('upload');
    Route::post('/admin/import-module-note/{sem_id}-{module_id}-{session}','UploadController@importNoteModule')->name('etudiant.notes.import');
    Route::get('/admin/export-module-notes/{sem_id}-{module_id}-{session}-{type}','UploadController@exportModule')->name('etudiant.notes.module.export');
    Route::get('/admin/export-notes/{id}','UploadController@exportnotes')->name('etudiant.notes.export');
    Route::get('/admin/export','UploadController@export')->name('export');
    Route::get('/admin/export-all-formations','UploadController@exportAllFormations')->name('exportallformations');
    Route::get('/admin','MainController@admin')->name('admin');
    Route::get('/logout','UserController@logout')->name('logout');

    Route::get('/admin/formation/modules/{id}','FormationController@getModules')->name('formation.modules');
});


