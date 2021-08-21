<div class="col-md-9">

    <p><h2>Ajouter Une Nouvelle Formation</h2></p>
    @if($errors->any())
        <div class="note note-danger">
            <p>Attention ! On a pas pu enregistrer le module.</p>
        </div>
    @endif
    <form class="row container p-5 needs-validation" method="post" action="/module" novalidate>
        @csrf

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
        <div class="border d-flex justify-content-center p-4 mt-4">
            @if(!isset($modules))
            <div class="d-flex align-items-center">
                <figcaption class="figure-caption">Aucun module n'est pas encore selectionné</figcaption>
                <button type="button" class="btn btn-primary btn-floating ms-1 " data-toggle="modal" data-target="#popup">
                    <i class="fas fa-plus"></i>
                </button>

                @include('parts.admin.formation.formation-popup')
            </div>
            @else
                <div class="">
                    @foreach ($modules as $module )

                    <p >{{$module}}</p>

                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success"><h6>Crée La Formation</h6></button>
        </div>
    </form>
</div>
