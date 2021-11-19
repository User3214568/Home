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
            <th>Carte D'identite Nationale</th>
            <td>{{ Auth::user()->cin }}</td>
            <th>Num Télephone</th>
            <td>{{ Auth::user()->phone }}</td>
        </tr>
    </table>
</div>
<div class="table-responsive mt-4">
    <h5>Mon Historique</h5>
    @if (sizeof($affectations) <= 0)
        <div class="p-3 mt-2 justify-content-center">
            <div class="alert alert-info">Rien à afficher dans votre historique.</div>
        </div>
    @else
        
    <div class="container">
        <ul class="timeline">
            @foreach ($affectations as $au=>$items)
                <li>
                    <div class="timeline-badge primary">
                        <i class="fa fa-clipboard-list"></i>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h5 class="timeline-title">{{ $au."-".($au+1) }}</h5>
                        </div>
                        <div class="timeline-body">
                            <table class="table table-border">
                                @foreach ($items as $item )
                                <tr>
                                    <td>{{$item->module->name}}</td>
                                    <td>{{$item->formation->name}}</td>
                                    <td>{{$item->somme}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
    </div>
    @endif
</div>



