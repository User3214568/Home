<script src="/javascript/notes.js"></script>
<div class="row mt-4">
    <h2>Evalution des Etudiants</h2>
</div>
<?php $formation = App\Formation::get()[0] ?>
<div class="row">
    <p class=" note note-info">Vous devez choisir une formation pour modifier les notes des etudiants.</p>
</div>

<div class="row mt-3 justify-content-center">
    <div class="col-6">
        <select id="formation-select" class="text-reset border col-md-3 p-2 w-100" name="" id="">
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
        <p>Aucune Donnée à afficher. Veuillez verifier que avez sélectionner une formation.
            Si cette zone est toujours vide on vous invite à crée des nouveau étudiant
        </p>
        <a href="{{route('etudiant.create')}}" class="btn btn-danger"><h6>Ajouter des Etudiants</h6></a>
    </div>
</div>


  <!-- Tabs content -->
<div class="row" id="etudiants-notes"></div>
<!-- Tabs content -->
</div>
