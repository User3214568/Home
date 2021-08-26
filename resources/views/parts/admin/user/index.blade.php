<div class="row">
    <h2>Vos Utilisateurs</h2>
    <p>Vous pouvez consulter la list des utilisateurs dans la table ci-dessous ou bien
        ajouter, modifier ou crée un nouveau utilisateur.
    </p>
</div>
<div class="row justify-content-between p-3">
    <div class="col-4 form-outline ">
        <i class="fas fa-search trailing"></i>
        <input type="text" id="etudiants-search" value="" name="name" class="form-control form-icon-trailing"  />
        <label class="form-label"  for="etudiants-search">Rechercher un Etudiant</label>
    </div>
    <a class="col-2 btn  btn-primary btn-lg btn-floating" href="{{route("user.create")}}">
        <i class="fas fa-plus"></i>
    </a>
</div>
<div class="row">
    <table class="table align-middle table-hover m-md-3" id="etudiants-table">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Email</th>
                <th scope="col">Telephone</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php $count=1?>
            @foreach ($users as $user)
                <tr scope="row">
                    <th scope="col">{{$count}}</th>
                    <td scope="col">{{$user->first_name}}</td>
                    <td scope="col">{{$user->last_name}}</td>
                    <td scope="col">{{$user->email}}</td>
                    <td scope="col">{{$user->phone}}</td>
                    <td scope="col">
                        <a class="btn btn-success btn-lg btn-floating" href="{{route("user.edit",$user->cin)}}">
                            <i class="fas fa-pen-nib"></i>
                        </a>

                        <form class="d-inline" method="post" action="{{route('user.destroy',$user->cin)}}">
                            @csrf
                            @method('delete')
                            <button  class="btn btn-danger btn-lg btn-floating" data-mdb-ripple-color="dark">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php $count++ ?>
            @endforeach
        </tbody>
    </table>

</div>
