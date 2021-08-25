<div class="row">
    <h2>Vos Formations</h2>
</div>
<div class="row">
    <div class="dropdown-divider"></div>
    @if( sizeof($formations) > 0 )
        @foreach ($formations as $formation)
            @include('parts.admin.formation.formation-card')
        @endforeach
    @else
        <div class="text-reset">Aucune Formation existe pour le moment. Essayer d'ajouter des nouvelles formations</div>
    @endif

    <div class="border  col-3   card text-center m-4">
        <div class="card-body ">
        <a class="card-text text-primary" href="{{route('formation.create')}}">
            <i class="fas fa-plus fa-9x"></i>
        </a>
        <p>Ajouter une Nouvelle Formation</p>
        </div>
    </div>

</div>
