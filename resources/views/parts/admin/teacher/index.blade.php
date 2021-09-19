<div class="row">
    <h2>Professeurs</h2>
    <hr class="dropdiwn-divider">
    <p>Vous pouvez consulter la list des professeurs dans la table ci-dessous ou bien
        ajouter, modifier ou supprimer un professeur.
    </p>
</div>
<div class="row justify-content-between p-3">
    <div class="col-4 form-outline ">
        <i class="fas fa-search trailing"></i>
        <input type="text" id="etudiants-search" value="" name="name" class="form-control form-icon-trailing"  />
        <label class="form-label"  for="etudiants-search">Rechercher un Professeur</label>
    </div>
    <a href="{{route('teacher.create')}}" class="btn btn-primary btn-floating">
        <i class="fas fa-plus"></i>
    </a>
</div>

<div class="row table-responsive mt-4">
    <table class="table align-middle table-hover" id="etudiants-table" >
        <thead class="table-dark align-middle">
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Modules</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if(sizeof($teachers) < 1)
            <tr>
                <td colspan="5">Aucun Professeurs à afficher</td>
            </tr>
            @else
                @foreach ($teachers as $teacher)
                <tr name="filter">
                    <td>{{$teacher->id}}</td>
                    <td>{{$teacher->first_name}}</td>
                    <td>{{$teacher->last_name}}</td>
                    <td>

                    </td>
                    <td class="">
                        <a href="{{route('teacher.edit',['teacher'=>$teacher->id])}}" class="btn btn-success btn-floating">
                            <i class="fas fa-pen-fancy"></i>
                        </a>
                        <form class="d-inline" action="{{route('teacher.destroy',['teacher'=>$teacher->id])}}" method="post">
                        @csrf
                        @method("delete")
                        <button class="btn btn-danger btn-floating ">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @endif

        </tbody>
    </table>
</div>
