<script type="module" src="/javascript/list-etudiants.js"></script>
@extends('parts.admin.common.list-payement-tranche')
@section('title-list', 'List des Etudiants')
@section('route-import', route('etudiant.import', ['id' => 0]))
@section('route-create', route('etudiant.create'))
@section('route-export-empty', route('etudiant.export', ['id' => 0, 'type' => 'true']))
@section('route-export', route('etudiant.export', ['id' => 0, 'type' => 'false']))
@section('table')
    <tr>
        <th>Formation</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>CIN</th>
        <th>Promotion</th>
        <th>Actions</th>
    </tr>
    @if(sizeof($etudiants) == 0)
        <tr><td colspan="6">Aucun Etudiant à afficher.</td></tr>
    @else
        @foreach ($etudiants->sortBy('formation_id') as $etudiant)
            <tr name="versement">
                <th>{{ $etudiant->formation->name }}</th>
                <th>{{ $etudiant->first_name }}</th>
                <th>{{ $etudiant->last_name }}</th>
                <th>{{ $etudiant->cin }}</th>
                <th>{{ $etudiant->promotion->nom }}</th>
                <td class="d-flex justify-content-center  align-items-center">
                    <form action="{{ route('etudiant.destroy', ['etudiant' => $etudiant->cin]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-outline-danger btn-floating">
                            <i class="fas fa-times  fa-1x"></i>
                        </button>
                    </form>
                    <form action="{{ route('etudiant.edit', ['etudiant' => $etudiant->cin]) }}" method="GET">
                        <button class="btn btn-outline-secondary ms-1 btn-floating">
                            <i class="fas fa-pen-fancy fa-1x"></i>
                        </button>
                    </form>

            </tr>
        @endforeach
    @endif
@endsection
