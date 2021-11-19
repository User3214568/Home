<script type="module" src="/javascript/upload-export.js"></script>

<div class="row">
    <h2>Importer des Etudiant</h2>
    <hr class="dropdown-divider">
</div>
<div class="row">
    <p class="text-reset">
        La liste ci-dessous contient la list des etudiants qui peuvent etre importer.
    </p>
</div>
<div class="row p-4 table-responsive">
    <table class="table align-middle table-hover text-nowrap" id="etudiants-table">
        <thead>
            <tr>
                <th scope="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkAll" checked />
                        <label class="form-check-label" for="checkAll">

                        </label>
                    </div>
                </th>
                <th scope="col">Formation</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">CIN</th>
                <th scope="col">Date Naissance</th>
                <th scope="col">Lieu de Naissance</th>
                <th scope="col">Email</th>
                <td scope="col">Téléphone</td>
            </tr>
        </thead>
        <tbody>
            @if (isset($etudiants) && sizeof($etudiants) > 0)

                @foreach ($etudiants as $etudiant)
                    <tr>
                        <td scope="row" name="selected">
                            <div class="form-check">
                                <input class="form-check-input etudiant-check" type="checkbox" value=""
                                    id="check_{{ $etudiant->cin }}" checked />
                                <label class="form-check-label" for="check_{{ $etudiant->cin }}"></label>
                            </div>
                        </td>
                        <td scope="row" name="formation_name"
                            formation="{{ isset($etudiant->formation) ? $etudiant->formation->id : '' }}">
                            {{ isset($etudiant->formation) ? $etudiant->formation->name : 'Undéfinie' }}</td>
                        <td scope="row" name="first_name">{{ $etudiant->first_name }}</td>
                        <td scope="row" name="last_name">{{ $etudiant->last_name }}</td>
                        <td scope="row" name="cin">{{ $etudiant->cin }}</td>
                        <td scope="row" name="born_date">{{ $etudiant->born_date }}</td>
                        <td scope="row" name="born_place">{{ $etudiant->born_place }}</td>
                        <td scope="row" name="email">{{ $etudiant->email }}</td>
                        <td scope="row" name="phone">{{ $etudiant->phone}}</td>
                        <td scope="row" name="promotion_id">{{ $etudiant->promotion_id}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @if (!isset($etudiants) || sizeof($etudiants) == 0)
        <div scope="row">
            <p>Aucun etudiant à afficher.</p>
        </div>
    @endif

    <div class="d-flex justify-content-end">
        <button class="btn btn-success me-2" id="import-valider">Importer les Etudiants</button>
        <button class="btn btn-danger">Annuler L'importation</button>
    </div>

</div>
<button type="button" id="modal-trigger" class="btn btn-primary" data-toggle="modal" data-target="#popup"
        hidden>
    </button>
@include('parts.admin.common.modal')
