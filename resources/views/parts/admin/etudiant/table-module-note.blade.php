<table class="table table-bordered  align-middle">
    <?php $count_columns = 0; ?>
    <thead>

        <tr>
            <td rowspan="1"></td>
            @foreach ($mymodule->devoirs as $devoir)
                @if ($devoir->session == $session)
                    <th>
                        {{ $devoir->name }}
                    </th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        <?php $empty_set = 0; ?>
        @if (sizeof($sem->promotion->etudiants) > 0)
            @foreach ($sem->promotion->etudiants as $etudiant)
                @if ($etudiant->hasSession($session))
                    <?php $empty_set++; ?>
                    <tr>
                        <th scope="row">{{ $etudiant->first_name . ' ' . $etudiant->last_name }}</th>
                        @if (sizeof($mymodule->devoirs) > 0)
                            @foreach ($mymodule->devoirs as $devoir)
                                @if ($devoir->session == $session)
                                    <?php $evaluation = $etudiant->evaluations->where('devoir_id', $devoir->id)->first(); ?>
                                    <td class="border" name="note" id="{{ $evaluation->id }}" contenteditable="true">
                                        {{ $evaluation->note ?: 0 }}
                                    </td>
                                @endif
                            @endforeach
                        @else
                            <td>Aucune Note</td>
                        @endif
                    </tr>
                @endif
            @endforeach
        @else
            <td colspan="{{ $count_columns + 1 }}">Aucun Etudiant appartient à cette Promotion</td>
        @endif
        @if ($empty_set == 0)
            <td colspan="2">Aucun Etudiant Rattrapant. Veuillez verifier que vous avez Valider
                les notes du session Ordinaire.</td>
        @endif

    </tbody>
</table>
@if (!isset($result))
<div class="row justify-content-around p-3">
    <button id="{{ $mymodule->id . '-' . $sem->id }}" onclick="save(this)" name="savenote"
        title="Enregistrer les modifications" class="col-md-6 btn btn-success">
        Enregistrer Les Modifications de cet Onlget
    </button>
    <button id="{{ $promotion->id }}" onclick="save(this)" name="savenote" title="Enregistrer les modifications"
        class="col-md-3 btn btn-info btn-wrap">
        Commiter les notes et Préparer les RATT
    </button>
</div>
@endif
