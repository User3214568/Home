<table class="table table-bordered  align-middle">
    <?php $count_columns = 0; ?>
    <thead>

        <tr>
            <td rowspan="1"></td>
            <th>Code Massar</th>
            <th>Nom et Prénom</th>
            <th>Note Final</th>
            <th>Résultat Final</th>

        </tr>
    </thead>
    <tbody>

        @if (sizeof($sem->promotion->etudiants) > 0)

            @foreach ($sem->promotion->etudiants as $key => $etudiant)
                @if ($etudiant->hasSession($mymodule->id,$session))
                    <tr>
                        <th>{{ $key + 1 }}</th>
                        <th scope="row">{{ $etudiant->cne }}</th>
                        <th scope="row">{{ $etudiant->first_name . ' ' . $etudiant->last_name }}</th>
                        @if (sizeof($mymodule->devoirs) > 0)
                            <?php
                                if($session == 1){
                                    $note = App\Utilities\Validation::validateSessionModule($etudiant->cin,$mymodule->id,$session,false);
                                }else{
                                    $note = App\Utilities\Validation::FinalModuleNote($etudiant->cin,$mymodule->id);
                                }
                            ?>
                            <th scope="row">{{ $note }}</th>
                            <td>{{ $note >= $etudiant->formation->critere->note_validation ? 'Validé' : ($note >= $etudiant->formation->critere->note_aj ? 'Non Validé' : 'Ajourné') }}</td>
                        @else
                            <td>Aucune Note</td>
                        @endif
                    </tr>
                @endif
            @endforeach
        @else

            <td colspan="{{ $count_columns + 1 }}">Aucun Etudiant appartient à cette Promotion</td>
        @endif

    </tbody>
</table>
