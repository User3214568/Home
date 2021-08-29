<script src="/javascript/notes.js"></script>

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
            Si cette zone est toujours vide on vous invite à crée des nouveaux modules , formations, étudiant
        </p>
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{route('etudiant.create')}}" class="btn btn-secondary m-3"><span class="h6">Ajouter des Etudiants</span></a>
            <a href="{{route('formation.create')}}" class="btn btn-success m-3"><span class="h6">Ajouter des Formations</span></a>
            <a href="{{route('module.create')}}" class="btn btn-info m-3"><span class="h6">Ajouter des Modules</span></a>
        </div>
    </div>
</div>


  <!-- Tabs content -->
<div class="row" id="etudiants-notes"></div>
<!-- Tabs content -->
</div>
