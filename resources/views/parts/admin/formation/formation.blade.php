<div class="col-md-9">
    <p><h2>Ajouter Une Nouvelle Formation</h2></p>
    @if($errors->any())
        <div class="note note-danger">
            <p>Attention ! On a pas pu enregistrer la Formation.</p>
        </div>
    @endif
    <form class="row container p-5 needs-validation" method="post" action="/formation" novalidate>
        @csrf

        <p><h5>Information de la Formation</h5><hr class="dropdown-divider"></p>
        <div class="form-outline">
            <input type="text" id="input_name" name="name" class="form-control" required />
            <label class="form-label"  for="input_name">Nom de la Formation</label>
            <div class="invalid-feedback mt-1">Veuillez saisir le nom de la formation.</div>
        </div>
        <div class="form-outline mt-4">
            <textarea class="form-control" id="input_desc" name="description" rows="4" required></textarea>
            <label class="form-label" for="input_desc">Description de la Formation</label>
            <div class="invalid-feedback mt-1">Veuillez saisir la description de la formation.</div>
        </div>
        <div class=" d-flex justify-content-start flex-column   mt-4">
            <div class="w-100"  >
                <p class="text-reset"><h5>Répartion des Semestres</h5></p>
                <p><hr class="dropdown-divider"></p>
            </div>
            @include('parts.admin.formation.semestre')
        </div>
        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success"><h6>Crée La Formation</h6></button>
        </div>
        <input type="text" value="" name="semestres" hidden id="semestres-data" />
    </form>
</div>
