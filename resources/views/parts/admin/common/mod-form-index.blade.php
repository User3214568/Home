<div class="row">
    <h2>Vos {{ucwords($target)."s"}}</h2>
</div>
<div class="row ">
    <div class="dropdown-divider"></div>
    <div class="border  col-md-3   card text-center m-4">
        <div class="card-body ">
        <a class="card-text text-primary" href="{{route("$target".'.create')}}">
            <i class="fas fa-plus fa-9x"></i>
        </a>
        <p>Ajouter un{{isset($formations)?'e Nouvelle ':' Nouveau '}} {{ucwords($target)}}</p>
        </div>
    </div>
    @if(isset($formations) && sizeof($formations) > 0 )
        @foreach ($formations as $formation)
        <?php $name = $formation->name;
              $description = $formation->description;
              $target = 'formation';
              $id = $formation->id
        ?>
            @include('parts.admin.formation.formation-card')
        @endforeach
    @elseif( isset($modules) && sizeof($modules)>0)
        @foreach ($modules as $module)
        <?php $name = $module->name;
              $description = $module->description;
              $target = 'module';
              $passed = \App\Utilities\Calculation::time_diff($module->updated_at);
              $id = $module->id;
        ?>
            @include('parts.admin.common.card')
        @endforeach
    @else
        <div class="text-reset">Aucun{{isset($formations)?'e formation':' module'}} n'existe pour le moment. Essayer d'ajouter des nouvelles formations</div>
    @endif



</div>
