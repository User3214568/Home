<table class="table table-bordered  align-middle">
    <?php $count_columns = 0; ?>
    <thead>

        <tr>
            <td rowspan="1"></td>
            @foreach ($mymodule->devoirs as $devoir)
                <th>
                    {{ $devoir->name }}
                </th>
            @endforeach

        </tr>
    </thead>
    <tbody>

        @if (sizeof($sem->promotion->etudiants) > 0)
            @foreach ($sem->promotion->etudiants as $etudiant)
                <tr>
                    <th scope="row">{{ $etudiant->first_name . ' ' . $etudiant->last_name }}</th>
                    @if (sizeof($mymodule->devoirs) > 0)
                        @foreach ($mymodule->devoirs as $devoir)
                            <?php $evaluation = $etudiant->evaluations->where('devoir_id', $devoir->id)->first(); ?>
                            <td class="border" name="note" id="{{ $evaluation->id }}" contenteditable="true">
                                {{ $evaluation->note ?: 0 }}
                            </td>
                        @endforeach
                    @else
                        <td>Aucune Note</td>
                    @endif
                </tr>
            @endforeach
        @else

            <td colspan="{{ $count_columns + 1 }}">Aucun Etudiant appartient à cette Promotion</td>
        @endif

    </tbody>
</table>
