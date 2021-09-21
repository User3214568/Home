<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>

                <th>CIN</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Résultat</th>
                <th>NV</th>
                <th>AJ</th>
                <th>Décision Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promotion->etudiants as $etudiant)
                <tr>

                    <td>{{$etudiant->cin}}</td>
                    <td>{{$etudiant->first_name}}</td>
                    <td>{{$etudiant->last_name}}</td>
                    <?php
                        $result = \App\Utilities\Validation::result($etudiant->cin)
                    ?>
                    <td>{{$result['note']}}</td>
                    <th class="text-warning">{{$result['nv']}}</td>
                    <th class="text-danger">{{$result['aj']}}</td>
                    <th>
                        <select class="p-2" name="select-decision" id="{{$promotion->id}}" e="{{$etudiant->cin}}">
                            <option value="0" {{$result['final']==1?'selected':''}}>Validé(e)</option>
                            <option value="1" {{$result['final']==0?'selected':''}}>Ajourné(e)</option>
                        </select>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
