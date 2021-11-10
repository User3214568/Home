<div class="row">
    <h2>Liste de Mes Paiements</h2>
    <hr class="dropdown-divider" />
</div>
<table class='table'>
    <tr>
        <th>Formation</th>
        <th>Montant Payé</th>
        <th>Date du Paiement</th>

    </tr>
    @if(sizeof($paiements)<1)
        <tr>
            <td colspan="3">Vous n'avez aucun paiement pour le moment.</td>
        </tr>
    @else
        @foreach ($paiements as $paiement)
        <tr>
            <td>{{$paiement->formation->name}}</td>
            <td>{{$paiement->montant}}</td>
            <td>{{$paiement->date_payement}}</td>
        </tr>
        @endforeach
    @endif
</table>
