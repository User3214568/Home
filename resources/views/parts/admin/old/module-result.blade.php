<div class="table-responsive">

    <table class="table align-middle  text-nowrap">
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
                    @php
                    $result =  $history->hisresults->where('module_id',$module->id)->first()->note_final;


                    @endphp
               {{number_format($result,2)}}
            </td>
            <td>
                {{\App\Utilities\Validation::resultDesc($history->etudiant->formation,$result)}}
            </td>
        </tr>
        @endif

        @endforeach
    </table>

</div>
