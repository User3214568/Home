<script src="/javascript/teacher.js"></script>
<div class="row p-2">
    <h2>Historique des Affectations des Professeurs</h2>
    <hr class="dropdiwn-divider">
</div>
<div class="row justify-content-between p-3">
    <div class="col-4 form-outline ">
        <i class="fas fa-search trailing"></i>
        <input type="text" id="etudiants-search" value="" name="name" class="form-control form-icon-trailing" />
        <label class="form-label" for="etudiants-search">Rechercher un Professeur</label>
    </div>
</div>

<div class="row table-responsive mt-4 p-2">
    <table class="table align-middle table-hover" id="etudiants-table">
        <tr>
            <th>Formation</th>
            <th>Module</th>
            <th>Professeur</th>
            <th>Date Affectation</th>
            <th>Somme</th>
            <th></th>
        </tr>
        @if(sizeof($allprofs) > 0 )
            @foreach ($allprofs as $formation_name => $profs)
            <?php $passed = false;?>
                @foreach ($profs as $prof)
                    <tr name="filter">
                        @if(!$passed)
                        <?php $passed = true; ?>
                        <td  rowspan="{{ sizeof($profs) }}">{{ $formation_name }}</td>
                        @endif
                        <td hidden>{{ $formation_name }}</td>
                        <td>{{ $prof->module->name }}</td>
                        <td>{{ $prof->teacher->user->name() }}</td>
                        <td>{{ $prof->created_at }}</td>
                        <td>{{ $prof->somme }}</td>
                        <td class="d-flex justify-content-center  align-items-center">
                            <form action="{{ route('professeur.destroy', ['professeur' => $prof->id]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="btn btn-outline-danger btn-floating">
                                    <i class="fas fa-times  fa-1x"></i>
                                </button>
                            </form>
                        </td>

                @endforeach
                </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5">Aucune donnée à afficher.</td>
            </tr>
            @endif
    </table>
</div>
