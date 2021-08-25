<script src="/javascript/upload-export.js"></script>
<div class="col-md-9">

    <p><h2>
        @if(!isset($import))
            Manipulation des Etudiants
        @else
            Importer des Etudiant
        @endif
    </h2></p>

    <div class="mt-4"><h5>Ajouter ou Importer et Exporter des Etudiants</h5></div>
    <div class="dropdown-divider"></div>
    <div class="p-4 d-flex justify-content-around">
        <button id="btn-upload" type="button" class="btn btn-success btn-rounded">
            <i class="fas fa-cloud-upload-alt fa-lg"></i>
            Importer depuis Excel
        </button>
        <a id="btn-export" type="button" class="btn btn-info btn-rounded" href="{{route('export')}}">
            <i class="fas fa-file-export fa-lg"></i>
            Exporter des Etudiants
        </a>
        <a href="{{route('etudiant.create')}}" id="btn-add" type="button" class="btn btn-info btn-rounded">
            <i class="fas fa-plus fa-lg"></i>
            Ajouter un Etudiant
        </a>
    </div>
    <form  class="border p-4 col d-flex flex-column justify-content-center" method="post" action="{{route('upload')}}" enctype="multipart/form-data" >
        @csrf
        <p id="empty-files">Aucun fichier Excel n'est selectionné pour le moment</p>
        <input type="file" id="upload-id" name="file[]" hidden multiple>
        <div id="selected-files" class=" d-flex flex-wrap justify-content-center flex-row"></div>
        <p><button id="submit-files" class="btn btn-dark" hidden>Importer Les Fichiers</button></p>
        <div id="card-file" class="card p-2" hidden>
            <div class="card-body d-flex justify-content-center flex-column">
              <div class="d-flex justify-content-end mb-2"><i id="file-delete" file-index=''  class="fas fa-times" onclick='dropFile(this)'></i></div>
              <h5 class="card-title">Fichier Excel</h5>
              <p class="card-text">
                <img src="/images/excel.png" height="70"/>
              </p>
              <p id="filename" class="text-reset"></p>
              <p id="filesize" class="text-reset"></p>
            </div>
        </div>
    </form>
    <div class="mt-4"><h5>Rechercher Modifier ou Supprimer des Etudiants</h5></div>
    <div class="dropdown-divider"></div>
    <div class="row justify-content-center align-items-center p-4">
        <div class="col-md-5">
            <select class="text-reset border col-md-3 p-2 w-100" name="" id="etudiant-formation">
                    <option value="" disabled selected>Choisissez une Formation </option>
                    @if(isset($formations))
                        @foreach ($formations as $formation)
                            <option  value="{{$formation->name}}">{{$formation->name}}</option>
                        @endforeach
                    @endif
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
    <div class="row p-4 table-responsive nowrap">
        <table class="table align-middle table-hover" id="etudiants-table">
            <thead>
              <tr>
                <th scope="col">
                        <div class="form-check">
                            <input
                            class="form-check-input"
                            type="checkbox"
                            value=""
                            id="checkAll"
                            checked
                            />
                            <label class="form-check-label" for="checkAll">

                            </label>
                        </div>
                </th>
                <th scope="col">CNE</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">CIN</th>
                <th scope="col">Formation</th>
                <th scope="col">Email</th>
                <th scope="col" class="my-nowrap">Date Naissance</th>
                @if(!isset($import))
                    <th scope="col">Actions</th>
                @endif
              </tr>
            </thead>
            <tbody>
                @if(isset($etudiants) && sizeof($etudiants)>0)

                @foreach ($etudiants as $etudiant )
                    <tr>
                        <td scope="row" name="selected">
                            <div class="form-check">
                                <input
                                  class="form-check-input etudiant-check"
                                  type="checkbox"
                                  value=""
                                  id="check_{{$etudiant->id}}"
                                  checked
                                />
                                <label class="form-check-label" for="check_{{$etudiant->id}}"></label>
                            </div>
                        </td>
                        <td scope="row" name="cne">{{$etudiant->cne}}</td>
                        <td scope="row" name="first_name">{{$etudiant->first_name}}</td>
                        <td scope="row" name="last_name">{{$etudiant->last_name}}</td>
                        <td scope="row" name="cin">{{$etudiant->cin}}</td>
                        <td scope="row" name="formation_name" formation="{{$etudiant->formation->id}}">{{$etudiant->formation->name}}</td>
                        <td scope="row" name="email">{{$etudiant->email}}</td>
                        <td scope="row" name="born_date">{{$etudiant->born_date}}</td>

                        @if(!isset($import))
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
                        @endif
                    </tr>
                @endforeach
              @endif
            </tbody>
          </table>
          @if(!isset($etudiants) || sizeof($etudiants)==0)
                <div scope="row"><p>Aucun etudiant à afficher.</p></div>
          @endif
          @if(isset($import))
            <div class="d-flex justify-content-end">
              <button class="btn btn-success" id="import-valider">Importer les Etudiants</button>
              <button class="btn btn-danger">Annuler L'importation</button>
            </div>
          @endif
    </div>
</div>

