<script type="module" src="/javascript/list-versement.js"></script>
@extends('parts.admin.common.list-payement-tranche')
@section('title-list','Versements des Etudiants')
@section('route-import',route('finance.import.versement'))
@section('route-create','tranche.create')
@section('route-export',route('finance.export.formation', ['id' => 0, 'type' => 'false']))
@section('route-export-empty',route('finance.export.formation', ['id' => 0, 'type' => 'true']))
@section('table')
<tr class="">
    <th rowspan="3">Formation</th>
    <th rowspan="3">Nom</th>
    <th rowspan="3">Prénom</th>
    <th rowspan="3">CIN</th>
    <th colspan="16">Versements</th>
    <th rowspan="3">Total Versé</th>
    <th rowspan="3">Rest</th>
</tr>
<tr>
    <th colspan="4">Versement 1</th>
    <th colspan="4">Versement 2</th>
    <th colspan="4">Versement 3</th>
    <th colspan="4">Versement 4</th>
</tr>
<tr>
    <th>Montant</th>
    <th>Référence</th>
    <th>Date</th>
    <th></th>
    <th>Montant</th>
    <th>Référence</th>
    <th>Date</th>
    <th></th>
    <th>Montant</th>
    <th>Référence</th>
    <th>Date</th>
    <th></th>
    <th>Montant</th>
    <th>Référence</th>
    <th>Date</th>
    <th></th>
</tr>
@foreach ($etudiants as $etudiant)
    <tr name="versement">
        <td>{{ $etudiant->formation->name }}</td>
        <td>{{ $etudiant->first_name }}</td>
        <td>{{ $etudiant->last_name }}</td>
        <td>{{ $etudiant->cin }}</td>
        <?php $sum = 0; ?>
        @foreach ($etudiant->tranches->sortBy('date_vers') as $tranche)
            <td class="{{ $tranche->proved ? 'text-success' : 'text-danger' }}">{{ $tranche->vers }}</td>
            <td class="{{ $tranche->proved ? 'text-success' : 'text-danger' }}">{{ $tranche->ref }}</td>
            <td class="{{ $tranche->proved ? 'text-success' : 'text-danger' }}">{{ $tranche->date_vers }}</td>
            <td class="d-flex justify-content-center  align-items-center">
                <form action="{{route('tranche.destroy',['tranche'=>$tranche->id])}}" method="POST">
                    @csrf
                    @method('delete')
                    <button class="btn btn-outline-danger btn-floating">
                        <i class="fas fa-times  fa-1x"></i>
                    </button>
                </form>
                <form action="{{route('tranche.edit',['tranche'=>$tranche->id])}}" method="GET">
                    <button class="btn btn-outline-secondary ms-1 btn-floating">
                        <i class="fas fa-pen-fancy fa-1x"></i>
                    </button>
                </form>
            </td>
            <?php $sum += $tranche->vers; ?>
        @endforeach

        @for ($i = sizeof($etudiant->tranches); $i < 4; $i++)
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        @endfor
        <td>{{ $sum }}</td>
        <td>{{ 16000 - $sum }}</td>
    </tr>
@endforeach
@endsection
