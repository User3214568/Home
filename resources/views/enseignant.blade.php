@extends('parts.layout.page')

@section('title')
    Gestionnaire de Formation | Gestion Pédagogique et Financiére
@stop

<?php
    $items = [
        ['title'=>'Acceuil','link'=> route('admin'), 'icon'=>'fas fa-home', 'expanded'=>false ],
        ['title'=>'Notes De Mes Etudiants','link'=>route('enseignant.notes'), 'icon'=>'fas fa-code-branch', 'expanded'=>false],
        ['title'=>'Mes Paiements','link'=>route('module.index') , 'icon'=>'fas fa-th', 'expanded'=>false],
    ];
?>

@section('content')
    @include('parts.layout.navbar')
    @include('parts.enseignant.dash.ens-content')
@stop

