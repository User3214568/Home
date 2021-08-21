@extends('parts.layout.page')

@section('title')
    Gestionnaire de Formation | Gestion Pédagogique et Financiére
@stop

<?php

    $items = [
        ['title'=>'Acceuil', 'icon'=>'', 'expanded'=>false ],
        ['title'=>'Formation', 'icon'=>'fas fa-code-branch', 'expanded'=>true ,  'sub_items' => ['Crée une nouvelle formation','Modifier des Formations','Suppression des Formations']],
        ['title'=>'Module', 'icon'=>'fas fa-th', 'expanded'=>true ,  'sub_items' => ['Crée un nouveau Module','Modifier des Modules', 'Suppression des Modules']],
        ['title'=>'Etudiant', 'icon'=>'fas fa-user-graduate', 'expanded'=>true ,  'sub_items' => ['Crée un nouveau Etudiant','Modifier des Etudiants', 'Suppression des Etudiants']],
        ['title'=>'Utilisateur', 'icon'=>'fas fa-user-lock', 'expanded'=>true ,  'sub_items' => ['Crée un nouveau Utilisateur','Modifier des Utilisateurs', 'Suppression des Utilisateur']]

    ];
?>

@section('content')
    @include('parts.layout.navbar')
    @include('parts.admin.dashboard.admin-content')
    @include('parts.layout.footer')
@stop

