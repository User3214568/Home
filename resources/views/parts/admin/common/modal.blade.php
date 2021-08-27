

  <!-- Modal -->
  <div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="modalContent">
        <div class="modal-header" >
          <h5 class="modal-title" id="modal-title-id">Ajouter une Semestre</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-id">


            <div class="form-outline mt-3">
                <input type="text" id="search-module" class="form-control" />
                <label class="form-label" for="search-module">Veuillez Rechercher et Selectionner vos Modules</label>
            </div>
            <div class=" shadow-2 p-2">
                <ul class="search" id="search-result">
                    @if(isset($modules))
                    @foreach ($modules as $module )
                    <div class="form-check p-2">
                        <input
                        class="form-check-input"
                        type="checkbox"
                        value="{{ $module->name }}"
                        id="{{ $module->id }}"
                        />
                        <label class="form-check-label" for="{{ $module->id }}">
                            {{ $module->name }}
                        </label>
                    </div>

                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="close-popup" class="btn btn-secondary" data-dismiss="modal" >Fermer</button>
          <button type="button" class="btn btn-primary" id="saveModules" data-dismiss="modal">Enregistrer les modifications</button>
        </div>
      </div>
    </div>
  </div>
