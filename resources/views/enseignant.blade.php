@extends('parts.layout.page')

@section('title')
    Gestionnaire de Formation | Gestion Pédagogique et Financiére
@stop

<?php
    $items = [
        ['title'=>'Acceuil','link'=> route('admin'), 'icon'=>'fas fa-home', 'expanded'=>false ],
        ['title'=>'Notes De Mes Etudiants','link'=>route('enseignant.notes'), 'icon'=>'fas fa-award', 'expanded'=>false],
        ['title'=>'Mes Paiements','link'=>route('enseignant.paiements') , 'icon'=>'fas fa-donate', 'expanded'=>false],
    ];
?>

@section('content')
    @include('parts.layout.navbar')
    @include('parts.enseignant.dash.ens-content')
@stop

