@extends('parts.layout.page')
@section('title')
    Gestionnaire de Formation | Gestion Pédagogique et Financiére
@stop
@section('content')
@include('parts.layout.navbar')
<?php $error = " Un Problème lié a notre base de données à ete survenu.
"?>
@include('parts.admin.common.error')

@stop
