<div class="w-100 d-flex justify-content-center align-items-center p-2" id="modules">
    <div id="selected" class="w-100">
        @if(!(sizeof($semestres)==0))
        <span class="text-reset" id="semestre-empty">Aucune semestre n'est crée pour le moment</span>
        @endif
    </div>
    <div class="w-100 d-flex justify-content-end">
        <button id="add-formation-btn" type="button" class="btn btn-primary btn-floating ms-1 mt-2 align-self-right " data-toggle="modal" data-target="#popup">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    @include('parts.admin.formation.formation-popup')
</div>
