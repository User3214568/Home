<table class="table">
    <tr>
        <td>CIN</td>
        <td>Nom et Prénom</td>
        @foreach ($profs[0]->module->devoirs as $dev)
            @if ($dev->session == $session)
                <td>{{ $dev->name }}</td>
            @endif
        @endforeach
    </tr>
    @php
        $promo = $profs[0]->findPromotion();
        $count = 0;
    @endphp
    @if ($promo)
        @foreach ($promo->etudiants as $e)
            @if ($e->hasSession($profs[0]->module->id, $session))
                <tr>
                    <td>{{ $e->cin }}</td>
                    <td>{{ $e->name() }}</td>
                    @foreach ($profs[0]->module->devoirs as $dev)
                        @if ($dev->session == $session)
                            @php
                                $eval = $e->evaluations
                                    ->where('etudiant_cin', $e->cin)
                                    ->where('devoir_id', $dev->id)
                                    ->first();
                            @endphp
                            @if ($eval)
                                <td>{{ $eval->note ?: 0 }}</td>
                            @endif
                        @endif
                    @endforeach
                </tr>
                @php
                    $count++;
                @endphp
            @endif
        @endforeach
        @if($count == 0)
                <tr><td>Aucun Rattrapant</td></tr>
        @endif
    @else
        <tr><td>Aucun Etudiant</td></tr>
    @endif
</table>
