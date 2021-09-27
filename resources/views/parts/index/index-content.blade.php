<div class="container p-3">
    <p class="mt-4">
    <h2>Gestionnaire Pédagogique et Financière des Formations</h2>
    </p>
    <div class="row  justify-content-center">
        <div class="col-lg-6  d-flex justify-content-center align-items-center flex-column">
            <p>
                <span class="h3 lead">
                    Bonjour et Bienvenu dans votre Gestionnaire des Formations, Vous etes un Professeur ou un
                    Administrateur, On vous invite à se connecter à votre compte pour acceder à nos fonctionnalitées
                </span>
            </p>
            @if (Auth::check())
                <a class="btn btn-outline-info mt-1  lead" href="/admin">
                    <h6>
                        Acceder à mon Espace @php Auth::user()->type == 0 ?' Admin':' Professeur' @endphp
                    </h6>
                </a>
            @else
                <a class="btn btn-outline-info mt-1  lead" href="/login">
                    <h6>
                        Acceder à Votre Compte
                    </h6>
                </a>
            @endif
        </div>
        <div class="col-lg-6 justify-content-center align-items-center">
            <img src="/images/homelogo.png" class="img-fit" alt="">
        </div>
    </div>

    <div class="row mt-4" id="func">
        <p>
        <h3>Nos Fonctionnalitées</h3>
        </p>
    </div>

    <div class="row  justify-content-around align-items-stretch">
        <div class="col-md-5 row align-items-stretch border p-2">

                <span class="lead">Gérer Vos Formations et Vos Modules</span>
                <div class="col-3 align-self-center text-success">
                    <i class="fas fa-sitemap fa-5x"></i>
                </div>
                <div class="col align-self-center">
                    <ul>
                        <li>Créer, Modifier, Supprimer des Formation, Semestres, Modules</li>
                        <li>Configurer la répartition des modules sur les semestres de chaque formation</li>
                        <li>Gérer le régime d'evaluations des étudiants</li>
                    </ul>
                </div>


        </div>
        <div class="col-md-5 border p-2 row align-items-stretch ">

                <span class="lead">Gérer Vos Etudiants</span>
                <div class="col-3 text-secondary align-self-center">
                    <i class="fas fa-user-graduate fa-5x"></i>
                </div>
                <div class="col align-self-center">
                    <ul>
                        <li>Méttre a jour vos étudiants</li>
                        <li>Gérer les notes des Etudiants et le déroulement des semestres</li>
                        <li>Effectuer des Délibrations du fin d'année pour les étudiants.</li>
                    </ul>
                </div>


        </div>
        <div class="col-md-5 mt-2 row align-items-stretch  border p-2">

                <span class="lead">Gérer Vos Enseignants</span>
                <div class="col-3 align-self-center text-info">
                    <i class="fas fa-chalkboard-teacher fa-5x"></i>
                </div>
                <div class="col align-self-center">
                    <ul>
                        <li>Méttre a jour vos Enseignants</li>
                        <li>Répartir vos modules sur vos enseignants</li>
                        <li>Crée des Espaces dédier aux enseignants pour les permettre de consulter leurs etat actuel et de modifier les notes de leurs etudants</li>
                    </ul>
                </div>


        </div>
        <div class="col-md-5 mt-2 row align-items-stretch border p-2">

                <span class="lead">Gérer Vos Finances</span>
                <div class="col-3  align-items-center text-primary">
                    <i class="fas fa-file-invoice-dollar fa-5x"></i>
                </div>
                <div class="col align-items-center">
                    <ul>
                        <li>Gérer l'etat du paiement du chaque étudiant</li>
                        <li>Gérer les paiements des enseignants</li>
                        <li>Bilan Finacière englobe tous les formations </li>
                    </ul>
                </div>


        </div>
    </div>



</div>
