
<div class="row">
    <h2>Années Universitaires Précédentes</h2>
    <hr class="dropdown-divider">
</div>

<div class="row mt-4">
    @if (sizeof($formations) == 0)
        <div class="row text-center">
            Vous n'avez pas des années universitaire antérieurs à afficher. Verifier que vous avez
            effectuer les délibration du fin d'année dans la section Etudiants > Délibrations
        </div>
    @endif
    @include("parts.admin.old.header")
</div>

