<script type="module" src="/javascript/notes.js"></script>

<div class="row mt-4 ">
    <h2>
        @hasSection('title_ad')
            @yield('title_ad')
        @else
            Evaluation des Etudiants
        @endif
    </h2>
</div>
<div class="row mt-1"><hr class="dropdown-divider"></div>
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
<div class="row mt-3">
    <p class=" note note-info">Vous devez choisir une formation pour modifier les notes des etudiants.</p>
</div>

<div class="row mt-3 justify-content-center">
    <div class="col-6">
        <select id="formation-select" target="@yield('target')" class="text-reset border col-md-3 p-2 w-100" name="" id="">
            <option disabled selected>Sélectionner une Formation</option>
            @foreach ($formations as $form)
                <option value="{{$form->id}}">{{$form->name}}</option>
            @endforeach
        </select>
    </div>

</div>

<div class="border row p-4 mt-4" id="empty-notes">
    <div class="d-flex flex-column justify-content-center align-items-center">

        <p class="text-danger"><i class="fas fa-info  fa-5x"></i></p>
        <p>
            Aucune Donnée à afficher. Veuillez verifier que vous avez sélectionner une formation.
            Si vous n'avez pas encore créer des formations on vous invite à les créées.
        </p>
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{route('formation.create')}}" class="btn btn-success m-3"><span class="h6">Ajouter des Formations</span></a>
        </div>
    </div>
</div>


  <!-- Tabs content -->
<div class="row" id="etudiants-notes"></div>
<!-- Tabs content -->
</div>
