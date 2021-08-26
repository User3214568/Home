<nav class="navbar navbar-expand-md navbar-light bg-light p-3 sticky-top ">

    <a href="#" class="d-flex">
        <img class="border-end p-2" src="/images/logo.png" height="70"/>
        <div class="d-flex justify-content-start flex-column ms-2">
            <span class="navbar-brand" >Gestionnaire de Formation</span>
            <span class="text-reset">Gestion Pédagogique et Financiaire</span>

        </div>
    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarToggleExternalContent"
      aria-controls="navbarToggleExternalContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars fa-lg"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggleExternalContent">
        <ul class="navbar-nav ms-auto d-flex align-items-center">
            <li class="nav-item">
                <a href="{{route('home')}}" class="nav-link">Page d'Acceuil</a>
            </li>
            <li class="nav-item">
                <a href="#func" class="nav-link">Nos Fonctionnalitées</a>
            </li>
            <li class="nav-item">
                <a href="#about" class="nav-link">A propos de Nous</a>
            </li>

            @if(!Auth::check())
                <li class="nav-item">
                    <a class="border-start btn btn-link text-reset d-flex align-items-center" href="/login">
                      <i class="fas fa-user-circle fa-3x m-2"></i>
                      Accéder à mon compte
                    </a>
                </li>
            @else

            <div class="dropstart ">
                <li class="nav-item dropdown">
                    <a
                      class="nav-link dropdown-toggle d-flex align-items-center"
                      href="#"
                      id="navbarDropdownMenuLink"
                      role="button"
                      data-mdb-toggle="dropdown"
                      aria-expanded="false"
                    >
                      <img
                      src="https://mdbootstrap.com/img/new/avatars/8.jpg"
                      class="rounded-circle"
                        height="40"
                        alt=""
                        loading="lazy"
                      />
                    </a>
                    <ul class="dropdown-menu p-2" aria-labelledby="navbarDropdownMenuLink">
                        <img
                                src="https://mdbootstrap.com/img/new/avatars/8.jpg"
                                class="rounded-circle p-3"
                                height="150"
                                alt=""
                        />

                        <h5 class=""><strong>{{Auth::user()->first_name}} {{" "}} {{Auth::user()->last_name}}</strong></h5>
                        <p class="text-muted">{{Auth::user()->email}}</p>
                        <li><a class="dropdown-item" href="{{route('user.edit',Auth::user()->cin)}}">Mon Profile</a></li>
                        <li><a class="dropdown-item" href="{{route('admin')}}">Table de Bord</a></li>
                        <li>
                        <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="{{route('logout')}}">Se Déconnecter</a></li>
                    </ul>
                  </li>
              </div>




            @endif
        </ul>

    </div>
</nav>
