<div class="table-responsive">

    <table class="table align-middle">
        <tr>
            <th>CIN</th>
            <th>Nom et Prénom</th>
            <th>Note Finale</th>
        <th>Résultat Finale</th>
    </tr>
    @foreach ($histories as $history)
    @if(isset($history->etudiant))
    <tr>
        <td>{{$history->etudiant_cin}}</td>
        <td>{{$history->etudiant->name()}}</td>
        <td>
            {{number_format(($count != 0)?$moy/$count:0,2)}}
        </td>
        <td>
            {{\App\Utilities\Validation::resultDesc($history->etudiant->formation,$moy,1)}}
        </td>
    </tr>
    @endif

    @endforeach
</table>

</div>
