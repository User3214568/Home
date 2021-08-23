<div class="col-md-9">
    <p><h2>Ajouter un Nouveau Module</h2></p>
    @if($errors->any())
        <div class="note note-danger">
            <p>Attention ! On a pas pu enregistrer le module.</p>
        </div>
    @endif
    <form class="row container p-5 needs-validation" method="post" action="{{route('module.store')}}" novalidate>
        @csrf
        <div class="form-outline">
            <input type="text" id="input_name" name="name" class="form-control" required />
            <label class="form-label"  for="input_name">Nom du Module</label>
            <div class="invalid-feedback mt-1">Veuillez saisir le nom du module.</div>
        </div>
        <div class="form-outline mt-4">
            <textarea class="form-control" id="input_desc" name="description" rows="4" required></textarea>
            <label class="form-label" for="input_desc">Description du Module</label>
            <div class="invalid-feedback mt-1">Veuillez saisir la description du module.</div>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success"><h6>Crée Le Module</h6></button>
        </div>
    </form>
</div>
