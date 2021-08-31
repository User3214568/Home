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
                @if ($etudiant->hasSession($session))
                    <tr>
                        <th>{{ $key + 1 }}</th>
                        <th scope="row">{{ $etudiant->cne }}</th>
                        <th scope="row">{{ $etudiant->first_name . ' ' . $etudiant->last_name }}</th>
                        @if (sizeof($mymodule->devoirs) > 0)
                            <?php $note = 0; ?>
                            @foreach ($mymodule->devoirs as $devoir)

                            @endforeach
                            <th scope="row">{{ $note }}</th>
                            <td>{{ $note >= 12 ? 'Validé' : ($note >= 8 ? 'Non Validé' : 'Ajourné') }}</td>
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
