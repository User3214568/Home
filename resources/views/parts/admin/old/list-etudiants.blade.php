<div class="table-responsive">
    <table class="table">
        <tr>
            <th>CIN</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de Naissance</th>
            <th>Lieu de Naissance</th>
            <th>Numéro de Téléphone</th>
        </tr>
        @foreach ($histories as $history)
        @if(isset($history->etudiant))
        <tr>
            <td>{{$history->etudiant->user->cin}}</td>
            <td>{{$history->etudiant->user->first_name}}</td>
            <td>{{$history->etudiant->user->last_name}}</td>
            <td>{{$history->etudiant->born_date}}</td>
            <td>{{$history->etudiant->born_place}}</td>
            <td>{{$history->etudiant->user->phone}}</td>
        </tr>
        @endif
        @endforeach
    </table>

</div>
