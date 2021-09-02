<p>
<h2>{{ !isset($etudiant) && !isset($user) && !isset($module) ? 'Ajouter ' . (isset($adj) ? $adj : 'Un Nouveau') . " $target" : "Modifier $target" }}
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

<form class="row container p-3 needs-validation" method="post" action="{{ $route }}" novalidate>
    @csrf
    @if (isset($etudiant) || isset($user) || isset($module))
        @method('put')
    @endif
    @if ($target == 'Paiement' || $target == 'Tranche')
        <div class="row justify-content-end">
            <button title="Importer Les {{$target}}s" class="col-1 btn btn-success btn-floating">
                <i class="fas fa-upload"></i>
            </button>
            <a href="" title="Exporter Les {{$target}}s" class="col-1 btn btn-danger btn-floating ms-2">
                <i class="fas fa-download"></i>
            </a>
        </div>
    @endif

    @foreach ($fields as $field)
        <div class="row mt-4">
            @if ($field['type'] == 'selection')

                <select class="col border rounded-2   p-2 text-reset" name="{{ $field['name'] }}"
                    id="input_{{ $field['name'] }}" required>
                    <option value="{{ $field['value'] }}" {{ !isset($etudiant) ? 'selected' : '' }} disabled>
                        {{ $field['label'] }}</option>
                    @foreach ($field['items'] as $item)
                        <option value="{{ $item->id ?: $item->cin }}"
                            {{ isset($etudiant) && $field['selected'] == ($item->id ?: $item->cin) ? 'selected' : '' }}>
                            {{ $item->name ?: ($item->nom ?: $item->first_name . ' ' . $item->last_name) }}
                        </option>
                    @endforeach
                </select>
            @elseif (($field['type'] == 'date'))

                <div class=" form-outline ">
                    <input type="{{ $field['type'] }}"
                        value="{{ isset($etudiant) ? $etudiant->born_date : date('Y-m-d') }}"
                        id="input_{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control"
                        required />
                    <label class="form-label"
                        for="input_{{ $field['name'] }}">{{ $field['label'] }}</label>
                    <div class="invalid-feedback mt-5">Veuillez saisir {{ $field['label'] }} .</div>
                </div>
            @elseif(($field['type'] == 'textarea'))

                <div class=" form-outline">
                    <textarea type="{{ $field['type'] }}" id="input_{{ $field['name'] }}"
                        name="{{ $field['name'] }}" class="form-control" rows="8"
                        required>{{ $field['value'] }}</textarea>
                    <label class="form-label"
                        for="input_{{ $field['name'] }}">{{ $field['label'] }}</label>
                    <div class="invalid-feedback mt-5">Veuillez saisir {{ $field['label'] }} .</div>
                </div>
        </div>
    @elseif(($field['type'] == 'checkbox'))
        <div class="form-check ">
            <input class="form-check-input" name="{{ $field['name'] }}" type="checkbox" value=""
                id="_{{ $field['name'] }}" />
            <label class="form-check-label" for="_{{ $field['name'] }}">
                {{ $field['label'] }}
            </label>

        @else

            <div class=" form-outline">
                <input type="{{ $field['type'] }}" id="input_{{ $field['name'] }}"
                    value="{{ $field['value'] }}" name="{{ $field['name'] }}" class="form-control"
                    required />
                <label class="form-label" for="input_{{ $field['name'] }}">{{ $field['label'] }}</label>
                <div class="invalid-feedback mt-5">Veuillez saisir {{ $field['label'] }} .</div>
            </div>
    @endif
    </div>

@endforeach
@if ($target == 'Module')
    <script src="/javascript/module.js"></script>
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
        <script async>
            var devs = {!! json_encode($module->devoirs) !!};
        </script>
    @endif
@endif
<div class="row mt-4 mb-4">
    <hr class="dropdown-divider">
</div>
<div class="mt-4 d-flex justify-content-end">
    <button class="btn btn-success">
        <h6>{{ !isset($etudiant) && !isset($user) && !isset($module) ? "Crée  $target" : "Modifier  $target" }}
        </h6>
    </button>
</div>
</form>
