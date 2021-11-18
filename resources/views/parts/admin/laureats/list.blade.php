<div class="row">
    <h2>Lauréats</h2>
    <hr class="dropdown-divider">
</div>
<div class="row justify-content-between p-3">
    <div class="col-12 col-sm-4 form-outline ">
        <i class="fas fa-search trailing"></i>
        <input type="text" id="etudiants-search" value="" name="name" class="form-control form-icon-trailing" />
        <label class="form-label" for="etudiants-search">Rechercher un Lauréat</label>
    </div>
    <select id="etudiant-formation " class="col-12 col-sm-4  border rounded-2 p-2 text-reset">
        <option value="" selected disabled>Selectionner une Formation</option>
        @foreach ($au as $annee => $grads)
            @foreach ($grads->groupBy('formation.name') as $name=>$g)
                <option value="{{ $name }}">{{ $name }}</option>
            @endforeach
        @endforeach
    </select>
    <select id="au-formation " class="col-12 col-sm-4  border rounded-2 p-2 text-reset">
        <option value="" selected disabled>Selectionner une Année Universitaire</option>
        @foreach ($au as $annee => $g)
            <option value="{{ $annee }}">{{ $annee }}</option>
        @endforeach
    </select>
</div>
<div class="row">
    <table class="table align-middle table-hover m-md-3" id="etudiants-table">
        <thead class="table-dark">
            <tr>
                <th scope="col">Formation</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Email</th>
                <th scope="col">AU D'obtention Diplome</th>
                <th scope="col">Telephone</th>
            </tr>
        </thead>
        <tbody id="etudiants-table ">
            @if (sizeof($au) > 0)
                @foreach ($au as $annee => $grads)
                    @foreach ($grads as $g)
                        <tr name='filter' scope="row">
                            <th scope="col">{{ $g->formation->name }}</th>
                            <td scope="col">{{ $g->etudiant->user->first_name }}</td>
                            <td scope="col">{{ $g->etudiant->user->last_name }}</td>
                            <td scope="col">{{ $g->etudiant->user->email }}</td>
                            <td scope="col">{{ $g->au }} </td>
                            <td scope="col">{{ $g->etudiant->user->phone }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td colspan="6">Aucun lauréat n'a ete trouver.</td>
                </tr>
            @endif
        </tbody>
    </table>

</div>
