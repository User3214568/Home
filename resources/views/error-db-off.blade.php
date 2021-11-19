@extends('parts.layout.page')
@section('title')
    Gestionnaire de Formation | Gestion Pédagogique et Financiére
@stop
@section('content')
@if(!isset($disableNav))
    @include('parts.layout.navbar')
@else
    <?php $error = " Un Problème lié a notre base de données à ete survenu."?>
@endif
@include('parts.admin.common.error')

@stop
