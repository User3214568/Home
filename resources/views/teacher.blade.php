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


    ];
?>

@section('content')
    @include('parts.layout.navbar')
    @include('parts.admin.dashboard.admin-content')
@stop

