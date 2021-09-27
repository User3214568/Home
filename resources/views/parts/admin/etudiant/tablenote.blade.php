<table class="table table-bordered  align-middle">
    <?php $count_columns = 0; ?>
    <tr>
        <td rowspan="2"></td>
        @foreach ($sem->modules as $module)
            @if (!isset($auth_modules) || (isset($auth_modules) && in_array($module->id, $auth_modules)))

                <th
                    colspan="{{ sizeof($module->devoirs->where('session', $session)) > 0 ? sizeof($module->devoirs->where('session', $session)) : 1 }}">
                    {{ $module->name }}
                </th>
            @endif
        @endforeach
    </tr>
    <tr>
        @foreach ($sem->modules as $module)
            @if (!isset($auth_modules) || (isset($auth_modules) && in_array($module->id, $auth_modules)))

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
            @endif
        @endforeach
    </tr>
    @php
        $counter = 0;
    @endphp
    @if(sizeof(array_intersect($sem->modules->pluck('id')->toArray(),$auth_modules)) > 0)
    @if (sizeof($sem->promotion->etudiants) > 0)
        @foreach ($sem->promotion->etudiants as $etudiant)
            @if ($etudiant->hasSessionSemestre($sem->id, $session))
                <tr>
                    <th scope="row">{{ $etudiant->first_name . ' ' . $etudiant->last_name }}</th>
                    @foreach ($sem->modules as $module)
                        @if (!isset($auth_modules) || (isset($auth_modules) && in_array($module->id, $auth_modules)))

                            @if (sizeof($module->devoirs) > 0)
                                @foreach ($module->devoirs as $devoir)
                                    @if ($devoir->session == $session)
                                        <?php $evaluation = $etudiant->evaluations->where('devoir_id', $devoir->id)->first(); ?>
                                        @if ($evaluation)
                                            <td class="border" name="note" id="{{ $evaluation->id }}"
                                                contenteditable="true">
                                                {{ $evaluation->note ?: 0 }}
                                            </td>
                                        @else
                                            <td class="border" contenteditable="false">
                                                Non Rattrappant
                                            </td>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                <td>Aucune Note</td>
                            @endif
                        @endif
                    @endforeach
                </tr>
                @php
                    if ($counter == 0) {
                        $counter++;
                    }
                @endphp
            @endif
        @endforeach
        @if ($counter == 0)
            @if ($session == 1)
                <td colspan="{{ $count_columns + 1 }}">Aucun Etudiant n'est inscrit dans la session ordinaire de ce
                    Module.</td>
            @else
                <td colspan="{{ $count_columns + 1 }}">Aucun Etudiant Rattrappant. Verifier bien que vous avez
                    commiter les notes du session ordinaire.</td>
            @endif
        @endif
    @else
        <td colspan="{{ $count_columns + 1 }}">Aucun Etudiant appartient à cette Promotion</td>
    @endif
@else
    <td colspan="{{ $count_columns + 1 }}">Vous n'avez pas le droit d'acceder à ce contenu.</td>
    @endif

</table>
