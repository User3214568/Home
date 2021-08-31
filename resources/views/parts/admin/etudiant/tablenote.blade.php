<table  class="table table-bordered  align-middle">
    <?php $count_columns = 0; ?>
    <tr>
        <td rowspan="2"></td>
        @foreach ($sem->modules as $module)
            <th
                colspan="{{ sizeof($module->devoirs->where('session', $session)) > 0 ? sizeof($module->devoirs->where('session', $session)) : 1 }}">
                {{ $module->name }}
            </th>
        @endforeach
    </tr>
    <tr>
        @foreach ($sem->modules as $module)
            @if (sizeof($module->devoirs) > 0)
                @foreach ($module->devoirs as $devoir)
                    @if ($devoir->session == $session)
                        <td>{{ $devoir->name }}</td>
                        <?php $count_columns++; ?>
                    @endif
                @endforeach
            @else
                <?php $count_columns++; ?>
                <td> Aucun Devoir</td>
            @endif
        @endforeach
    </tr>
    @if (sizeof($sem->promotion->etudiants) > 0)
        @foreach ($sem->promotion->etudiants as $etudiant)
            @if ($etudiant->hasSession($session))
                <tr>
                    <th scope="row">{{ $etudiant->first_name . ' ' . $etudiant->last_name }}</th>
                    @foreach ($sem->modules as $module)
                        @if (sizeof($module->devoirs) > 0)
                            @foreach ($module->devoirs as $devoir)
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
                    @endforeach
                </tr>
            @endif
        @endforeach
    @else
        <td colspan="{{ $count_columns + 1 }}">Aucun Etudiant appartient à cette Promotion</td>
    @endif

</table>
@if (sizeof($promotion->semestres) > 0 && !isset($result))
    <div class="row justify-content-around p-3">
        <button  onclick="save(this)" name="savenote" title="Enregistrer les modifications"
            class="col-md-6 btn btn-success btn-wrap">
            Enregistrer Les Modifications de cet Onlget
        </button>
        <button  onclick="save(this)" name="savenote" title="Enregistrer les modifications"
            class="col-md-3 btn btn-info btn-wrap">
            Commiter les notes et Préparer les RATT
        </button>
    </div>

@endif
