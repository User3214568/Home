@extends('parts.layout.page')

@section('title')
    Gestionnaire de Formation | Gestion Pédagogique et Financiére
@stop

<?php

    $items = [
        ['title'=>'Acceuil','link'=> route('admin'), 'icon'=>'fas fa-home', 'expanded'=>false ],
        ['title'=>'Gestion Pédagogique','divider'=>true],
        ['title'=>'Formations','link'=>route('formation.index'), 'icon'=>'fas fa-code-branch', 'expanded'=>false],
        ['title'=>'Modules','link'=>route('module.index') , 'icon'=>'fas fa-th', 'expanded'=>false],

        ['title'=>'Etudiants', 'icon'=>'fas fa-user-graduate', 'expanded'=>true, 'sub_items'=>
            [
                ['title'=>'Adminer Vos Etudiants','link'=>route('etudiant.index'),'icon'=>'fas fa-user-edit'],
                ['title'=>'Gestion des Notes','link'=>route('etudiant.evaluation'),'icon'=>'fas fa-award'],
                ['title'=>'Résultats des Etudiants','link'=>route('etudiant.result'),'icon'=>'fas fa-calculator'],
                ['title'=>'Délibrations','link'=>route('etudiant.delibration'),'icon'=>'fas fa-check'],

            ]
        ],
        ['title'=>'Professeurs','link'=>route('teacher.index'),'icon'=>'fas fa-chalkboard-teacher','expanded'=>false],
        ['title'=>'Affectation des Modules','link'=>route('professeur.index') , 'icon'=>'fas fa-th', 'expanded'=>false],

        ['title'=>'Utilisateurs','link'=>route('user.index'), 'icon'=>'fas fa-user-lock', 'expanded'=>false],
        ['title'=>'Années Prcédentes','link'=>route('user.index'), 'icon'=>'fas fa-user-lock', 'expanded'=>false],

        ['title'=>'Gestion Financiére','divider'=>true],
        ['title'=>'Versements des Etudiants','link'=>route('tranche.index') , 'icon'=>'fas fa-th', 'expanded'=>false],
        ['title'=>'Paiement des Professeurs','link'=>route('paiement.index') , 'icon'=>'fas fa-th', 'expanded'=>false],
        ['title'=>'Dépenses Communes','link'=>route('depense.index') , 'icon'=>'fas fa-th', 'expanded'=>false],

    ];
?>

@section('content')
    @include('parts.layout.navbar')
    @include('parts.admin.dashboard.admin-content')
    @include('parts.layout.footer')
@stop

