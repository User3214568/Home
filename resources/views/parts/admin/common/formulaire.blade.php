<p>
<h2>{{ !isset($etudiant) && !isset($teacher) && !isset($user) && !isset($module) && !isset($paiement) && !isset($tranche) && !isset($prof) && !isset($dep) ? 'Ajouter ' . (isset($adj) ? $adj : 'Un Nouveau') . " $target" : "Modifier $target" }}
</h2>
</p>
@if ($errors->any())
    <div class="note note-danger">
        <p>Attention ! On a pas pu enregistrer l'{{ $target }}.</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form class="row container p-3 needs-validation" method="post" action="{{ $route }}" novalidate  enctype="multipart/form-data">
    @csrf
    @if (isset($etudiant) || isset($teacher) || isset($user) || isset($module) || isset($tranche) || isset($dep) || isset($paiement) || isset($prof))
        @method('put')
    @endif
    @if ($target === "Utilisateur")
        <script src="/javascript/user.js"></script>
        <div class="d-flex justify-content center align-items-center flex-column">
            <div class="align-self-right">
                <button  id="image_button" type="button" class="btn btn-light btn-floating">
                    <i class="far fa-edit"></i>
                </button>
                <input type="file" onchange="readImage(this)" name="image" id="image_input" hidden>
            </div>
            <img id="image" class="rounded-circle" src="{{url(route('avatar',['cin'=> isset($user)?$user->cin:'none']))}}" height="180" alt="user image">
        </div>
    @endif
    @foreach ($fields as $field)

        @if ($field['type'] == 'selection')

            <select class="mt-4 border rounded-2 p-2 text-reset" name="{{ $field['name'] }}"
                id="input_{{ $field['name'] }}" required>
                <option value="{{ $field['value'] }}" {{ !isset($etudiant) || !isset($prof) ? 'selected' : '' }}
                    disabled>
                    {{ $field['label'] }}</option>
                @foreach ($field['items'] as $item)
                    <option value="{{ $item->id ?: $item->cin }}"
                        {{ isset($etudiant) || (isset($prof) && $field['selected'] == ($item->id ?: $item->cin)) ? 'selected' : '' }}>
                        {{ $item->name ?: ($item->nom ?: $item->user->first_name . ' ' . $item->user->last_name) }}
                    </option>
                @endforeach
            </select>

        @elseif (($field['type'] == 'date'))
            <div class="mt-4 form-outline ">
                <input type="{{ $field['type'] }}"
                    value="{{ isset($etudiant) ? $etudiant->born_date : date('Y-m-d') }}"
                    id="input_{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" required />
                <label class="form-label" for="input_{{ $field['name'] }}">{{ $field['label'] }}</label>
                <div class="invalid-feedback mt-1">Veuillez saisir {{ $field['label'] }} .</div>
            </div>
        @elseif(($field['type'] == 'textarea'))

            <div class="mt-4 form-outline">
                <textarea type="{{ $field['type'] }}" id="input_{{ $field['name'] }}"
                    name="{{ $field['name'] }}" class="form-control" rows="8"
                    required>{{ $field['value'] }}</textarea>
                <label class="form-label" for="input_{{ $field['name'] }}">{{ $field['label'] }}</label>
                <div class="invalid-feedback mt-1">Veuillez saisir {{ $field['label'] }} .</div>
            </div>

        @elseif(($field['type'] == 'checkbox'))
            <div class="form-check mt-4">
                <input class="form-check-input" name="{{ $field['name'] }}" type="checkbox" value=""
                    id="_{{ $field['name'] }}"
                    {{ (isset($field['checked']) ? $field['checked'] === 1 : false) ? 'checked' : '' }} />
                <label class="form-check-label" for="_{{ $field['name'] }}">
                    {{ $field['label'] }}
                </label>
            </div>
        @else

            <div class="mt-4 form-outline">
                <input type="{{ $field['type'] }}" id="input_{{ $field['name'] }}"
                    value="{{ $field['value'] }}" name="{{ $field['name'] }}" class="form-control" required />
                <label class="form-label" for="input_{{ $field['name'] }}">{{ $field['label'] }}</label>
                <div class="invalid-feedback mt-1">Veuillez saisir {{ $field['label'] }} .</div>
            </div>
        @endif


    @endforeach
    @if ($target == 'Module')
        <script type="module" src="/javascript/module.js"></script>
        <div class="row mt-4">
            <h5>Gestion des Devoirs de la Session Ordinaire du Module</h5>
        </div>
        <div class="row">
            <p class="text-reset">
                Veuillez ajouter les devoirs du session <span class="text-danger">Ordinaire</span> de votre
                module.
            </p>
        </div>
        <div class="row">
            <hr class="mt-2 dropdown-divider">
        </div>
        <div class="row" id="devoirs">
            <div class="row mt-3 justify-content-center" id="devoirDiv">
                <div class="col-3 form-outline">
                    <input type="text" id="name" class="form-control" />
                    <label class="form-label" for="name">Nom du Devoir</label>
                </div>
                <div class="col-3 ms-2 form-outline">
                    <input type="text" id="ratio" class="form-control" />
                    <label class="form-label" for="ratio">Pourcentage</label>
                </div>

                <div class="col-2">
                    <button type="button" id="check" class="btn btn-info btn-floating" hidden>
                        <i class="fas fa-check"></i>
                    </button>
                    <button type="button" id="addModule" class="btn btn-primary btn-floating">
                        <i class="fas fa-plus"></i>
                    </button>

                </div>
            </div>
        </div>
        <button type="button" id="modal-trigger" class="btn btn-primary" data-toggle="modal" data-target="#popup"
            hidden>
        </button>

        <!-- Devoirs Ratt -->

        <div class="row mt-4">
            <h5>Gestion des Devoirs de la Session Rattrappage du Module</h5>
        </div>
        <div class="row">
            <p class="text-reset">
                Veuillez ajouter les devoirs du session <span class="text-danger">Rattrappage</span> de votre
                module.
            </p>
        </div>
        <div class="row">
            <hr class="mt-2 dropdown-divider">
        </div>
        <div class="row" id="devoirs1">
            <div class="row mt-3 justify-content-center" id="devoirDiv1">
                <div class="col-3 form-outline">
                    <input type="text" id="name" class="form-control" />
                    <label class="form-label" for="name">Nom du Devoir</label>
                </div>
                <div class="col-3 ms-2 form-outline">
                    <input type="text" id="ratio" class="form-control" />
                    <label class="form-label" for="ratio">Pourcentage</label>
                </div>

                <div class="col-2">
                    <button type="button" id="check1" class="btn btn-info btn-floating" hidden>
                        <i class="fas fa-check"></i>
                    </button>
                    <button type="button" id="addModule1" class="btn btn-primary btn-floating">
                        <i class="fas fa-plus"></i>
                    </button>

                </div>
            </div>
        </div>
        <button type="button" id="modal-trigger" class="btn btn-primary" data-toggle="modal" data-target="#popup"
            hidden>
        </button>
        @include('parts.admin.common.modal')
        <input type="text" id="data" name="devoirs" hidden />
        @if (isset($module))
            <script>
                var devs = {!! json_encode($module->devoirs) !!};
            </script>
        @endif
    @endif
    <div class="row mt-4 mb-4">
        <hr class="dropdown-divider">
    </div>
    <div class=" d-flex justify-content-end">
        <button class="btn btn-success">
            <h6>{{ !isset($etudiant) && !isset($user) && !isset($teacher) && !isset($module) && !isset($tranche) && !isset($paiement) && !isset($prof) && !isset($dep) ? "Crée  $target" : "Modifier  $target" }}
            </h6>
        </button>
    </div>
</form>
