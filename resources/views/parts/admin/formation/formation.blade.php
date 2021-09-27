    <script src="/javascript/formation.js"></script>
    <p><h2>{{isset($formation)?'Editer La Formation '.$formation->name:'Ajouter Une Nouvelle Formation'}}</h2></p>
    @if($errors->any())
        <div class="note note-danger">
            <p>Attention ! On a pas pu enregistrer la Formation.</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="row container p-5 needs-validation" method="post" action="{{isset($formation)?route('formation.update',$formation):route('formation.store')}}" novalidate>
        @csrf
        @if(isset($formation))
            @method('put')
        @endif

        <p><h5>Information de la Formation</h5><hr class="dropdown-divider"></p>
        <div class="form-outline">
            <input type="text" id="input_name" name="name" class="form-control" value="{{ isset($formation)?$formation->name:'' }}" required />
            <label class="form-label"  for="input_name">Nom de la Formation</label>
            <div class="invalid-feedback mt-1">Veuillez saisir le nom de la formation.</div>
        </div>
        <div class="form-outline mt-4">
            <textarea class="form-control" id="input_desc" name="description" rows="8" required>{{isset($formation)?$formation->description:''}}</textarea>
            <label class="form-label" for="input_desc">Description de la Formation</label>
            <div class="invalid-feedback mt-1">Veuillez saisir la description de la formation.</div>
        </div>
        <div class="form-outline mt-4">
            <input type="number" id="input_prix" name="prix" class="form-control" value="{{ isset($formation)?$formation->prix:'' }}" required />
            <label class="form-label"  for="input_prix">Prix de la Formation</label>
            <div class="invalid-feedback mt-1">Veuillez saisir le prix de la formation.</div>
        </div>
        <div class="row mt-5"><h5>Régles de Validates des Modules et Semestres</h5></div>
        <div class="row"><hr class="dropdown-divider"></div>
        <p>Dans cette Zone vous remplissez les critères de validation des modules et des Semestre</p>
        <div class="row justify-content-center">
            <div class="col-sm-5 form-outline ms-2 mt-1">
                <input class="form-control" id="note_validation" value="{{isset($formation)?$formation->critere->note_validation:''}}" name="note_validation" required/>
                <label class="form-label" for="note_validation">Note de Validation</label>
                <div class="invalid-feedback mt-1">Veuillez saisir la note de validation.</div>
            </div>
            <div class="col-sm-5 form-outline ms-2 mt-1">
                <input class="form-control" id="note_validation" name="note_aj" value="{{isset($formation)?$formation->critere->note_aj:''}}" required/>
                <label class="form-label" for="note_aj">Note d'Ajournement</label>
                <div class="invalid-feedback mt-1">Veuillez saisir la note d'Ajournement.</div>
            </div>
            <div class="col-sm-5 form-outline ms-2 mt-4">
                <input class="form-control" id="aj" name="number_aj" value="{{isset($formation)?$formation->critere->number_aj:''}}" required/>
                <label class="form-label" for="aj">Nombre des AJ autorisé</label>
                <div class="invalid-feedback mt-1">Veuillez saisir le nombre des modules ajournées autorisé.</div>
            </div>
            <div class="col-sm-5 form-outline ms-2 mt-4">
                <input class="form-control" id="nv" name="number_nv" value="{{isset($formation)?$formation->critere->number_nv:''}}"  required/>
                <label class="form-label" for="nv">Nombre des NV autorisé</label>
                <div class="invalid-feedback mt-1">Veuillez saisir le nombre des modules non validées autorisé.</div>
            </div>
        </div>
        <div class=" d-flex justify-content-start flex-column   mt-4">
            <div class="w-100"  >
                <p class="text-reset"><h5>Répartion des Semestres</h5></p>
                <p><hr class="dropdown-divider"></p>
            </div>
            <div class="w-100" id="semestres">
                @include('parts.admin.formation.add-sem')
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success"><h6>{{isset($formation)?'Modifier La Formation':'Crée La Formation'}}</h6></button>
        </div>
        <input type="text" value="" name="semestres" hidden id="semestres-data" />
    </form>

    @if(isset($formation))
    <script>
        var semestres = {!! json_encode($formation->semestres->ids) !!};

    </script>
    @endif
