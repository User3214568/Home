<table class="table table-bordered  align-middle">
    <?php $count_columns = 0; ?>
    <thead>

        <tr>
            <td rowspan="1"></td>
            <th>CIN</th>
            <th>Nom et Prénom</th>
            <th>Note Moyenne</th>
            <th>Résultat</th>


        </tr>
    </thead>
    <tbody>

        @if (sizeof($sem->promotion->etudiants) > 0)
            @foreach ($sem->promotion->etudiants as $key => $etudiant)
                @if ($etudiant->hasSessionSemestre($sem->id,$session))
                    <tr>
                        <th>{{ $key + 1 }}</th>
                        <th scope="row">{{ $etudiant->cin }}</th>
                        <th scope="row">{{ $etudiant->first_name . ' ' . $etudiant->last_name }}</th>
                        <?php $glob_note = 0; ?>
                        @foreach ($sem->modules as $mymodule)
                            @if (sizeof($mymodule->devoirs) > 0)
                                <?php
                                if($session == 1){
                                    $note = App\Utilities\Validation::validateSessionModule($etudiant->cin,$mymodule->id,1,false);
                                }else $note = App\Utilities\Validation::FinalModuleNote($etudiant->cin,$mymodule->id);
                                ?>
                                <?php $glob_note += $note; ?>
                            @else
                                <td>Aucune Note</td>
                            @endif
                        @endforeach
                        <?php
                            if(sizeof($sem->modules) > 0 ){
                                    $glob_note = number_format($glob_note / sizeof($sem->modules),2);
                            }else{
                                $glob_note  = 0;
                            }
                        ?>
                        <td>{{ sizeof($sem->modules) > 0 ? $glob_note : '-' }}</td>
                        <td>{{ $glob_note >= $etudiant->formation->critere->note_validation ? 'Validé' : ($glob_note >= $etudiant->formation->critere->note_aj ? 'Non Validé' : 'Ajourné') }}</td>

                    </tr>
                @endif
            @endforeach
        @else

            <td colspan="{{ $count_columns + 1 }}">Aucun Etudiant appartient à cette Promotion</td>
        @endif

    </tbody>
</table>
