@extends('parts.admin.common.list-payement-tranche')
@section('title-list', 'List des Payements Effectués')
@section('route-import', route('finance.import.versement'))
@section('route-create', route('paiement.create'))
@section('route-import', route('finance.export.formation', ['id' => 0, 'type' => 'true']))
@section('route-export', route('finance.export.formation', ['id' => 0, 'type' => 'true']))
@section('table')
    <?php $paiements = App\Paiement::get()->groupBy('date_payement');
    $size = sizeof($paiements);
    $total = 0;
    ?>
    <tr>
        @foreach ($paiements as $key => $paiement)
            <td colspan="5">{{ 'Paiement des Professeurs, Le : ' }}<strong>{{ $key }}</strong></td>
        @endforeach
    </tr>
    <tr>
        @for ($i = 0; $i < $size; $i++)
            <td>Formation</td>
            <td>Module</td>
            <td>Professeur</td>
            <td>Montant</td>
            <td></td>
        @endfor
    </tr>
    @foreach ($paiements as $key => $d_paiement)
        <tr>
            @foreach ($d_paiement as $paiement)
                <td>{{ $paiement->formation->name }}</td>
                <td>{{ $paiement->professeur->module->name }}</td>
                <td>{{ $paiement->professeur->name }}</td>
                <td>{{ $paiement->montant }}</td>
                <td class="d-flex justify-content-center  align-items-center">
                    <form action="{{route('paiement.destroy',['paiement'=>$paiement->id])}}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-outline-danger btn-floating">
                            <i class="fas fa-times  fa-1x"></i>
                        </button>
                    </form>
                    <form action="{{route('paiement.edit',['paiement'=>$paiement->id])}}" method="GET">
                        <button class="btn btn-outline-secondary ms-1 btn-floating">
                            <i class="fas fa-pen-fancy fa-1x"></i>
                        </button>
                    </form>
                </td>
                <?php $total += $paiement->montant; ?>
            @endforeach
        </tr>
        <tr class="table-danger">
            <td colspan="2">Total Payé</td>
            <td colspan="3">{{$total}}</td>
        </tr>
    @endforeach


@endsection
