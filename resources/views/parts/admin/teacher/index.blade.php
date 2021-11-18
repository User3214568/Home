<script src="/javascript/teacher.js"></script>
<div class="row p-2">
    <h2>Professeurs</h2>
    <hr class="dropdiwn-divider">
    <p>Vous pouvez consulter la list des professeurs dans la table ci-dessous ou bien
        ajouter, modifier ou supprimer un professeur.
    </p>
    <div class="note note-info">
        Les professeurs crée par des administrateurs peuvent acceder à leurs espace professeur @auth
            <br>
            <ul>
                <li><strong>Username : </strong>Prénom.Nom@gest.ma</li>
                <li><strong>Mot de Passe : </strong>Prénom_En_Majuscule@Nom_En_Majuscule</li>
            </ul>
        @endauth
    </div>
</div>
<div class="row justify-content-between p-3">
    <div class="col-4 form-outline ">
        <i class="fas fa-search trailing"></i>
        <input type="text" id="etudiants-search" value="" name="name" class="form-control form-icon-trailing" />
        <label class="form-label" for="etudiants-search">Rechercher un Professeur</label>
    </div>
    <form class="col-md-6 d-flex justify-content-end" action="{{ route('teacher.import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <a href="{{ route('teacher.create') }}" class="btn btn-primary btn-floating">
            <i class="fas fa-plus"></i>
        </a>
        <input id="fileInput" type="file" name="file" hidden>
        <button type="button" id="importVersement" title="" class="col-1 btn btn-success btn-floating">
            <i class="fas fa-upload"></i>
        </button>
        <button type="submit" id="submit-import" hidden></button>
        <a href="{{route('teacher.export',['type'=>'false'])}}" id="export" title="" class="col-1 btn btn-danger btn-floating ">
            <i class="fas fa-download"></i>
        </a>
        <a href="{{route('teacher.export',['type'=>'true'])}}" id="exportEmpty"  title=""
            class="col-1 btn btn-dark btn-floating ">
            <i class="fas fa-download"></i>
        </a>
    </form>
</div>
<div class="row ">
    @if (isset($errors) && sizeof($errors->all())>0)
    <div class="col p-3 alert alert-danger">
        <ul>

            @foreach ($errors->all() as $err)
            <li>
                {{$err}}
            </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<div class="row table-responsive mt-4 p-2">
    <table class="table align-middle table-hover" id="etudiants-table">
        <thead class="table-dark align-middle">
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Prénom</th>

                <th></th>
            </tr>
        </thead>
        <tbody>
            @if (sizeof($teachers) < 1)
                <tr>
                    <td colspan="5">Aucun Professeurs à afficher</td>
                </tr>
            @else
                @foreach ($teachers as $teacher)
                    <tr name="filter">
                        <td>{{ $teacher->user->cin }}</td>
                        <td>{{ $teacher->user->first_name }}</td>
                        <td>{{ $teacher->user->last_name }}</td>

                        <td class="">
                            <a href="{{ route('teacher.edit', ['teacher' => $teacher->id]) }}"
                                class="btn btn-success btn-floating">
                                <i class="fas fa-pen-fancy"></i>
                            </a>
                            <form class="d-inline"
                                action="{{ route('teacher.destroy', ['teacher' => $teacher->id]) }}" method="post">
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
