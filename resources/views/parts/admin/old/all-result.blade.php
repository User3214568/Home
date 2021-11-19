<div class="table-responsive">

    <table class="table align-middle">
        <tr>
            <th>CIN</th>
            <th>Nom et Prénom</th>
            <th>Note Finale</th>
        <th>Résultat Finale</th>
    </tr>
    @php
        $count = 0 ; $moy = 0;
    @endphp
    @foreach ($histories as $history)
    @if(isset($history->etudiant))
    @foreach ($history->hisresults as $hisresult)
        @php
            $moy += $hisresult->note_final;
            $count++;
        @endphp
    @endforeach
    <tr>
        <td>{{$history->etudiant->user->cin}}</td>
        <td>{{$history->etudiant->user->name()}}</td>
        <td>
            {{number_format(($count != 0)?$moy/$count:0,2)}}
        </td>
        <td>
            {{\App\Utilities\Validation::resultDesc($history->promotion->formation,($count === 0 ) ?20 :$moy/$count,2)}}
        </td>
    </tr>
    @endif

    @endforeach
</table>

</div>
