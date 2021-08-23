<script src="/javascript/upload-export.js"></script>
<div class="col-md-9">
    <p><h2>Maniûlation des Etudiants</h2></p>

    <div class="mt-4"><h5>Ajouter ou Importer et Exporter des Etudiants</h5></div>
    <div class="dropdown-divider"></div>
    <div class="p-4">
        <button class="btn btn-primary" >Ajouter un Etudiant</button>
        <button class="btn btn-dark " onclick="upload()">Importer Liste des étudiants</button>
        <form action="" hidden>
            <input type="file" id="upload-id" name="upload" hidden multiple>
        </form>
        <div id="#status">STATE : </div>
        <button class="btn btn-dark ">Exporter Liste des étudiants</button>
    </div>
    <div class="mt-4"><h5>Rechercher Modifier ou Supprimer des Etudiants</h5></div>
    <div class="dropdown-divider"></div>
    <div class="row justify-content-center align-items-center p-4">
        <div class="col-md-5">
            <select class="text-reset border col-md-3 p-2 w-100" name="" id="etudiant-formation">
                    <option value="" disabled selected>Choisissez une Formation </option>
                    @foreach ($formations as $formation)
                        <option  value="{{$formation->name}}">{{$formation->name}}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-md-5">
            <div class="form-outline ">
                <i class="fas fa-search trailing"></i>
                <input type="text" id="etudiants-search" value="" name="name" class="form-control form-icon-trailing"  />
                <label class="form-label"  for="etudiants-search">Rechercher un Etudiant</label>
            </div>
        </div>


    </div>
    <div class="mt-4"><h5>List des Etudiants</h5></div>
    <div class="dropdown-divider"></div>
    <div class="row p-4">
        <table class="table align-middle table-hover" id="etudiants-table">
            <thead>
              <tr>
                <th scope="col">CNE</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">CIN</th>
                <th scope="col">Formation</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($etudiants as $etudiant )
                    <tr>
                        <td scope="row">{{$etudiant->cne}}</td>
                        <td scope="row">{{$etudiant->first_name}}</td>
                        <td scope="row">{{$etudiant->last_name}}</td>
                        <td scope="row">{{$etudiant->cin}}</td>
                        <td scope="row">{{$etudiant->formation->name}}</td>
                        <td scope="row">
                            <div class="d-flex">
                                <a class="btn btn-success btn-lg btn-floating" href="{{route('etudiant.edit',$etudiant)}}">
                                    <i class="fas fa-pen-nib"></i>
                                </a>
                                <form  action="{{route('etudiant.destroy',$etudiant)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button  class="btn btn-danger btn-lg btn-floating" data-mdb-ripple-color="dark">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                @endforeach

              </tr>

            </tbody>
          </table>
    </div>
</div>

