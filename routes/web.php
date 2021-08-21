<?php

use Illuminate\Support\Facades\Route;

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

Route::post('/login','UserController@login');
Route::get('/logout','UserController@logout');
Route::resource('/','MainController');
Route::get('/login','MainController@login');
Route::get('/restore-password','MainController@restorePassword');
Route::get('/admin','MainController@admin')->middleware('auth');
Route::resource('user','UserController');
Route::resource('formation','FormationController');
Route::resource('module','ModuleController');
Route::resource('etudiant','EtudiantController');



