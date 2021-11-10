<tr>
    <th scope="row">{{ $etudiant->user->name() }}</th>
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
                            @php
                                echo "count  : $mycount";
                                $mycount++;
                            @endphp
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
