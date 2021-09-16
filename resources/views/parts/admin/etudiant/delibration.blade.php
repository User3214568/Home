<script src="/javascript/delibration.js"></script>
<div class="row">
    <h2>Délibration</h2>
    <hr class="dropdown-divider">
</div>
<div class="row mt-4 justify-content-center">
    <select class="col-sm-5 p-2 me-3" name="formation" id="formation">
        <option value="0" disabled selected>Selectionner une Formation</option>
        @foreach ($formations as $formation)
            <option value="{{$formation->id}}">{{$formation->name}}</option>
        @endforeach
    </select>

</div>
<div id="target" class="row mt-5 border justify-content-center p-3">
    <p class="text-center">Sélectionner une Formation puis une Promotion pour Confirmer la décision du fin d'année pour chaque étudiant</p>
</div>
