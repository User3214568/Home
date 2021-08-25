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

Route::post('/login','UserController@login')->name('login');

Route::resource('/','MainController');
Route::get('/login','MainController@login');


Route::middleware(('auth'))->group(function(){
    Route::resource('/admin/user','UserController');
    Route::resource('/admin/formation','FormationController');
    Route::resource('/admin/module','ModuleController');
    Route::resource('/admin/etudiant','EtudiantController');
    Route::post('/admin/upload','UploadController@import')->name('upload');
    Route::get('/admin/export','UploadController@export')->name('export');
    Route::get('/admin','MainController@admin')->name('admin');
    Route::get('/logout','UserController@logout');
});


