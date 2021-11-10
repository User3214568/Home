<div class="row">
    <h2>Acceuil</h2>
    <hr class="dropdown-divider">
</div>
<div class="table-responsive mt-4">
    <h5>Informations Personnel</h5>

    <table class="table table-border">
        <tr>
            <th>Nom</th>
            <td>{{ Auth::user()->first_name }}</td>
            <th>Prénom</th>
            <td>{{ Auth::user()->last_name }}</td>
        </tr>
        <tr>
            <th>Formation</th>
            <td>{{ Auth::user()->etudiant->formation->name }}</td>
            <th>Niveau</th>
            <td>{{ Auth::user()->etudiant->promotion !== null ? Auth::user()->etudiant->promotion->nom : (Auth::user()->etudiant->promotion_id === 0 ? 'Lauréat' : '-') }}
            </td>
        </tr>
        <tr>
            <th>Date de Naissance</th>
            <td>{{ Auth::user()->etudiant->born_date }}</td>
            <th>Lieu de Naissance</th>
            <td>{{ Auth::user()->etudiant->born_place }}</td>
        </tr>
        <tr>
            <th>Carte D'identite Nationale</th>
            <td>{{ Auth::user()->cin }}</td>
            <th>Num Télephone</th>
            <td>{{ Auth::user()->phone }}</td>
        </tr>

    </table>
</div>


<div class="table-responsive mt-4">
    <h5>Parcour Universitaire</h5>
    <div class="container">
        <ul class="timeline">
            @if(sizeof($histories) > 0)
                @foreach ($histories as $item)
                    <li>
                        <div class="timeline-badge {{ $item->result === 'Admis' ? 'success' : 'danger' }}">
                            <i class="{{ $item->result === 'Admis' ? 'fa fa-check' : 'fas fa-undo' }}"></i>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h5 class="timeline-title">{{ $item->au }}</h5>
                            </div>
                            <div class="timeline-body">
                                <table class="table table-border">
                                    <tr>
                                        <th>Formation</th>
                                        <td>{{ $item->promotion->formation->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Promotion</th>
                                        <td>{{ $item->promotion->nom }}</td>
                                    </tr>
                                    <tr>
                                        <th>Résultat</th>
                                        <td>{{ $item->result }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </li>
                @endforeach
            @else
                <div class="text-center">
                    Aucune Donnée à afficher.
                </div>
            @endif
        </ul>
    </div>
</div>
