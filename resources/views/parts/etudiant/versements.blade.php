<div class="row">
    <h2>Mes Versements</h2>
    <hr class="dropdown-divider">
</div>
@php $total = 0 ; @endphp
<table class="table table-border mt-3">
    <tr>
        <th>Réference du versement</th>
        <th>Etat du Versement</th>
        <th>Montant Versé</th>
        <th>Date Versement</th>
    </tr>
    @if(sizeof($versements)>0)
        @foreach ($versements as $versement)
        <tr class="{{$versement->proved?'text-success':'text-danger'}}">
            <td>{{$versement->ref}}</td>
            <td>{{$versement->proved?'Verifié':'Non Vérifier'}}</td>
            <td>{{$versement->vers}}</td>
            <td>{{$versement->date_vers}}</td>
            @php
                $total += $versement->vers;
            @endphp
        </tr>
        <tr class="{{($etudiant->formation->prix - $total) > 0 ? 'bg-danger':'bg-success'}}">
            <th>Total Versé</th>
            <th>{{$total}}</th>
            <th>Restant</th>
            <th>{{$etudiant->formation->prix - $total}}</th>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4">
                Vous n'avez effectué aucun versement.
            </td>
        </tr>
    @endif
</table>
