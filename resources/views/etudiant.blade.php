@extends('parts.layout.page')

@section('title')
    Gestionnaire de Formation | Gestion Pédagogique et Financiére
@stop

<?php
    $items = [
        ['title'=>'Acceuil','link'=> route('etudiant.home'), 'icon'=>'fas fa-home', 'expanded'=>false ],
        ['title'=>'Mes Résultats','link'=>route('etudiant.resultspage'), 'icon'=>'fas fa-award', 'expanded'=>false],
        ['title'=>'Mes Versements','link'=>route('etudiant.versements') , 'icon'=>'fas fa-donate', 'expanded'=>false],
    ];
?>
@section('content')
    @include('parts.layout.navbar')
    @include('parts.etudiant.content')
@stop

