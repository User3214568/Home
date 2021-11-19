<table class="table table-bordered  align-middle">
    <?php $count_columns = 0; ?>
    <thead>

        <tr>
            <td></td>
            <th>CIN</th>
            <th>Nom et Prénom</th>
            <th>Note Final</th>
            <th>Résultat Final</th>

        </tr>
    </thead>
    <tbody>

        @if (sizeof($sem->promotion->etudiants) > 0)
            @php $counter = 0; @endphp
            @foreach ($sem->promotion->etudiants as $key => $etudiant)
                @if ($etudiant->hasSession($mymodule->id,$session))
                    @php $counter++; @endphp
                    <tr>
                        <th>{{ $key + 1 }}</th>
                        <th scope="row">{{ $etudiant->user->cin }}</th>
                        <th scope="row">{{ $etudiant->user->name() }}</th>
                        @if (sizeof($mymodule->devoirs) > 0)
                            <?php
                                if($session == 1){
                                    $note = App\Utilities\Validation::validateSessionModule($etudiant->cin,$mymodule->id,$session,false);
                                }else{
                                    $note = App\Utilities\Validation::FinalModuleNote($etudiant->cin,$mymodule->id);
                                }
                            ?>
                            <th scope="row">{{ $note }}</th>
                            <td>{{App\Utilities\Validation::resultDesc($etudiant->formation,$note,$session == 1 ? 1:0)}}</td>
                        @else
                            <td>Aucune Note</td>
                        @endif
                    </tr>
                @endif
            @endforeach
            @if($counter == 0 && $session == 2)
                <td colspan="{{ 5 }}">Aucun Etudiant Rattrapant. Veuillez verifier que vous avez Valider
                les notes du session Ordinaire.</td>
            @endif
        @else
            <td colspan="5">Aucun Etudiant appartient à cette Promotion</td>
        @endif

    </tbody>
</table>
