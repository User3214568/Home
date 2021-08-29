<table class="table table-bordered  align-middle">
    <?php $count_columns = 0; ?>
    <thead>

        <tr>
            <td rowspan="1"></td>
            <th>Code Massar</th>
            <th>Nom et Prénom</th>
            <th>Note Moyenne</th>


        </tr>
    </thead>
    <tbody>

        @if (sizeof($sem->promotion->etudiants) > 0)
            @foreach ($sem->promotion->etudiants as $key => $etudiant)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <th scope="row">{{ $etudiant->cne }}</th>
                    <th scope="row">{{ $etudiant->first_name . ' ' . $etudiant->last_name }}</th>
                    <?php $glob_note = 0; ?>
                    @foreach ($sem->modules as $mymodule)
                        @if (sizeof($mymodule->devoirs) > 0)
                            <?php $note = 0; ?>
                            @foreach ($mymodule->devoirs as $devoir)
                                <?php
                                $evaluation = $etudiant->evaluations->where('devoir_id', $devoir->id)->first();
                                if (!isset($evaluation->note)) {
                                    $evaluation->note = 0;
                                }
                                $note += ($devoir->ratio * $evaluation->note) / 100;
                                ?>
                            @endforeach
                            <?php $glob_note += $note ?>
                        @else
                            <td>Aucune Note</td>
                        @endif
                    @endforeach
                    <td>{{sizeof($sem->modules)>0?$glob_note/sizeof($sem->modules):'-'}}</td>

                </tr>
            @endforeach
        @else

            <td colspan="{{ $count_columns + 1 }}">Aucun Etudiant appartient à cette Promotion</td>
        @endif

    </tbody>
</table>
