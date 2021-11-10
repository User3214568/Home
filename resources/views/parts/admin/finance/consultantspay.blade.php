<script type="module" src="/javascript/list-payement.js"></script>
@extends('parts.admin.common.list-payement-tranche')
@section('title-list', 'List des Payements Effectués')
@section('route-import', route('paiement.import',['id'=>0]))
@section('route-create', route('paiement.create'))
@section('route-export-empty', route('paiement.export', ['id' => 0, 'type' => 'true']))
@section('route-export', route('paiement.export', ['id' => 0, 'type' => 'false']))
@section('table')
    <?php $paiements = App\Paiement::get()->groupBy('date_payement');
    $size = sizeof($paiements);
    ?>
    @if(sizeof($paiements)>0)
        @foreach ($paiements as $key => $d_paiement)
            <?php $total = 0; ?>
            <tr>
                <td>

                    <table class="table table-bordered table-sm align-middle text-center text-nowrap ">
                        <tr>
                            <td colspan="5">{{ 'Paiement des Professeurs, Le : ' }}<strong>{{ $key }}</strong></td>
                        </tr>
                        <tr>
                            <td>Formation</td>
                            <td>Professeur</td>
                            <td>Montant</td>
                            <td></td>
                        </tr>

                        @foreach ($d_paiement as $paiement)
                            <tr name="versement">
                                    <td>{{ $paiement->formation->name }}</td>
                                    <td>{{ $paiement->teacher->user->first_name." ".$paiement->teacher->user->first_name }}</td>
                                    <td>{{ $paiement->montant }}</td>
                                    <td class="d-flex justify-content-center  align-items-center">
                                        <form action="{{ route('paiement.destroy', ['paiement' => $paiement->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-outline-danger btn-floating">
                                                <i class="fas fa-times  fa-1x"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('paiement.edit', ['paiement' => $paiement->id]) }}"
                                            method="GET">
                                            <button class="btn btn-outline-secondary ms-1 btn-floating">
                                                <i class="fas fa-pen-fancy fa-1x"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <?php $total += $paiement->montant; ?>
                                </tr>
                                @endforeach
                            <tr class="table-danger">
                                <td colspan="2">Total Payé</td>
                                <td colspan="3">{{ $total }}</td>
                            </tr>


                    </table>
                </td>
            </tr>
        @endforeach
    @else
        <div class="p-4 border text-center">
            Aucun paiement à afficher. Verifiez que avez fait des paiements.
        </div>
    @endif
@endsection
