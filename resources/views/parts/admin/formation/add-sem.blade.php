<div id="sem-template" class="row  mt-1 justify-content-center border rounded-2 p-2">
    <div class="col row">
        <h5 class="lead" id="title">Ajouter une Nouvelle Semestre</h5>
        <hr class="dropdown-divider">
    </div>
    <div class="row justify-content-center">
        <div>Veuillez Selectionner les modules de cette semestre</div>
        <div class="limit-height ">

            <div class="col row align-items-center justify-content-center ">
                @foreach ($modules as $module)
                    <div class="col-lg-3 form-check m-2">
                        <input class="form-check-input" type="checkbox" value="{{$module->id}}" id="mod{{ $module->name }}" />
                        <label class="form-check-label" id="label-mod{{ $module->name }}" for="mod{{ $module->name }}">
                            {{ $module->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row justify-content-end mt-2">
        <button type="button" id="add-semestre" class="btn btn-primary   ">Crée Semestre</button>
        <button type="button" onclick="updateSemestre(this)" id="edit-semestre" class="btn btn-info btn-floating me-1" hidden><i class="fas fa-check"></i></button>
        <button type="button" onclick="deleteSemestre(this)" id="delete-semestre" class="btn btn-danger  btn-floating " hidden><i class="fas fa-trash-alt"></i></button>

    </div>

</div>
