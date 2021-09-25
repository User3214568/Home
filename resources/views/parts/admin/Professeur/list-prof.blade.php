<script type="module" src="/javascript/list-prof.js"></script>
@extends('parts.admin.common.list-payement-tranche')
@section('title-list', 'Liste des Professeurs')
@section('route-import', route('professeur.import', ['id' => 0]))
@section('route-create', route('professeur.create'))
@section('route-export', route('professeur.export', ['id' => 0, 'type' => 'false']))
@section('route-export-empty', route('professeur.export', ['id' => 0, 'type' => 'true']))
@section('table')

    <tr>
        <th>Formation</th>
        <th>Module</th>
        <th>Professeur</th>
        <th>Somme</th>
        <th></th>
    </tr>
    @if(sizeof($allprofs) > 0 )
        @foreach ($allprofs as $formation_name => $profs)
        <?php $passed = false;?>
            @foreach ($profs as $prof)
                <tr name="versement">
                    @if(!$passed)
                    <?php $passed = true; ?>
                    <td  rowspan="{{ sizeof($profs) }}">{{ $formation_name }}</td>
                    @endif
                    <td hidden>{{ $formation_name }}</td>
                    <td>{{ $prof->module->name }}</td>
                    <td>{{ $prof->teacher->user->first_name." ".$prof->teacher->user->last_name }}</td>
                    <td>{{ $prof->somme }}</td>

                    <td class="d-flex justify-content-center  align-items-center">
                        <form action="{{ route('professeur.destroy', ['professeur' => $prof->id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger btn-floating">
                                <i class="fas fa-times  fa-1x"></i>
                            </button>
                        </form>
                        <form action="{{ route('professeur.edit', ['professeur' => $prof->id]) }}" method="GET">
                            <button class="btn btn-outline-secondary ms-1 btn-floating">
                                <i class="fas fa-pen-fancy fa-1x"></i>
                            </button>
                        </form>
                    </td>

            @endforeach
            </tr>
        @endforeach
        @else
        <tr>
            <td colspan="5">Aucune donnée à afficher.</td>
        </tr>
        @endif
@endsection
