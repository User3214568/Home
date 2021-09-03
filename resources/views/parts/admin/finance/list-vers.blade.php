<script src="/javascript/versement.js"></script>
<div class="row">
    <h2>Versements des Etudiants</h2>
</div>
<div class="row">
    <hr class="dropdown-divider">
</div>

<div class="row mt-3 justify-content-center">
    <div class="col-6">
        <select id="formation-select" class="text-reset border col-md-3 p-2 w-100">
            <option value="0">Tous Les Formation</option>
            @foreach ($formations as $form)
                <option value="{{ $form->id }}">{{ $form->name }}</option>
            @endforeach
        </select>
    </div>

</div>
<div class="row mt-4 justify-content-around">
    <div class="col-sm-4 form-outline">
        <i class="fas fa-search trailing"></i>
        <input type="text" id="search" class="form-control form-icon-trailing" />
        <label class="form-label" for="search">Chercher </label>
    </div>

    <form method="post" action="{{ route('finance.import.paiement') }}" class="col-sm-7 d-flex justify-content-end "
        enctype="multipart/form-data">
        @csrf
        <a href="{{ route('tranche.create') }}"
            title="Ajouter un Versmeent d'un Etudiant" class="col-1 btn btn-primary btn-floating me-2">
            <i class="fas fa-plus"></i>
        </a>
        <input id="fileInput" type="file" name="file" hidden>
        <button type="button" id="importVersement" title="Importer Les Versementss"
            class="col-1 btn btn-success btn-floating" hidden>
            <i class="fas fa-upload"></i>
        </button>
        <button type="submit" id="submit-import" hidden></button>
        <a href="{{ route('finance.export.formation', ['id' => 0, 'type' => 'false']) }}" id="export"
            title="Exporter Les Versement" class="col-1 btn btn-danger btn-floating ms-2">
            <i class="fas fa-download"></i>
        </a>
        <a href="{{ route('finance.export.formation', ['id' => 0, 'type' => 'true']) }}" id="exportEmpty" hidden
            title="Exporter Fichier des Versements Vide" class="col-1 btn btn-dark btn-floating ms-2">
            <i class="fas fa-download"></i>
        </a>
    </form>
</div>
<div class="table-responsive mt-5">
    <table class="table table-bordered table-sm align-middle text-center text-nowrap " id="conten-table">
        <tr class="___class_+?16___">
            <th rowspan="3">Formation</th>
            <th rowspan="3">Nom</th>
            <th rowspan="3">Prénom</th>
            <th rowspan="3">CIN</th>
            <th colspan="16">Versements</th>
            <th rowspan="3">Total Versé</th>
            <th rowspan="3">Rest</th>
        </tr>
        <tr>
            <th colspan="4">Versement 1</th>
            <th colspan="4">Versement 2</th>
            <th colspan="4">Versement 3</th>
            <th colspan="4">Versement 4</th>
        </tr>
        <tr>
            <th>Montant</th>
            <th>Référence</th>
            <th>Date</th>
            <th></th>
            <th>Montant</th>
            <th>Référence</th>
            <th>Date</th>
            <th></th>
            <th>Montant</th>
            <th>Référence</th>
            <th>Date</th>
            <th></th>
            <th>Montant</th>
            <th>Référence</th>
            <th>Date</th>
            <th></th>
        </tr>
        @foreach ($etudiants as $etudiant)
            <tr name="versement">
                <td>{{ $etudiant->formation->name }}</td>
                <td>{{ $etudiant->first_name }}</td>
                <td>{{ $etudiant->last_name }}</td>
                <td>{{ $etudiant->cin }}</td>
                <?php $sum = 0; ?>
                @foreach ($etudiant->tranches->sortBy('date_vers') as $tranche)
                    <td class="{{ $tranche->proved ? 'text-success' : 'text-danger' }}">{{ $tranche->vers }}</td>
                    <td class="{{ $tranche->proved ? 'text-success' : 'text-danger' }}">{{ $tranche->ref }}</td>
                    <td class="{{ $tranche->proved ? 'text-success' : 'text-danger' }}">{{ $tranche->date_vers }}</td>
                    <td class="d-flex justify-content-center  align-items-center">
                        <form action="{{route('tranche.destroy',['tranche'=>$tranche->id])}}" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger btn-floating">
                                <i class="fas fa-times  fa-1x"></i>
                            </button>
                        </form>
                        <form action="{{route('tranche.edit',['tranche'=>$tranche->id])}}" method="GET">
                            <button class="btn btn-outline-secondary ms-1 btn-floating">
                                <i class="fas fa-pen-fancy fa-1x"></i>
                            </button>
                        </form>
                    </td>
                    <?php $sum += $tranche->vers; ?>
                @endforeach

                @for ($i = sizeof($etudiant->tranches); $i < 4; $i++)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endfor
                <td>{{ $sum }}</td>
                <td>{{ 16000 - $sum }}</td>
            </tr>
        @endforeach
    </table>
</div>
