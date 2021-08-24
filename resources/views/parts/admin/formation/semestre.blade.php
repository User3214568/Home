<div class="row  d-flex justify-content-center align-items-center p-2" id="modules">
    <div id="selected" class="w-100">
        @if(!(sizeof($semestres) == 0))
        <span class="text-reset" id="semestre-empty" {{isset($formation)?'hidden':''}}>Aucune semestre n'est crée pour le moment</span>
        @endif
        @if(isset($formation))
        @foreach ($formation->semestres as $semestre)

            <div class="row card mt-2 semestre" id="sem{{$semestre->numero}}">
                <div class="card-body">
                    <h5 class="card-title" id="sem-title">Semestre {{$semestre->numero}}</h5>
                    <hr class="dropdown-divider">
                    <div id="modules-selected" class="card-text wrap">
                        @foreach ($semestre->modules as $module)
                        <span class="p-2">{{$module->name}}</span>
                        @endforeach
                    </div>
                    <hr class="dropdown-divider">
                </div>
                <div class="mb-2">
                    <button type="button" id="edit-sem" class="btn btn-success btn-floating ms-1" data-toggle="modal" data-target="#popup" onclick="editSemestre(this)" name='{{$semestre->numero}}'><i class="fas fa-marker"></i></button>
                    <button type="button" id="delete-sem" class="btn btn-danger btn-floating ms-1 " onclick="deleteSemestre(this)" name="{{$semestre->numero}}"><i class="fas fa-trash-alt"></i></button></div></div>

        @endforeach
        @endif
    </div>
</div>
    <div class="row d-flex justify-content-end">
        <button id="add-formation-btn" type="button" class="btn btn-primary btn-floating ms-1 mt-2 align-self-right " data-toggle="modal" data-target="#popup">
            <i class="fas fa-plus"></i>
        </button>

    @include('parts.admin.formation.formation-popup')
    </div>
