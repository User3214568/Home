<form class="container mt-5 p-1 needs-validation" method="post" action="{{ !$is_login ? $url : '/login' }}" novalidate>
    {{ csrf_field() }}

    <div class="row justify-content-around">
        <div class="card rounded-0 col-lg-5 p-5">

            <div class="row">

                <div class="col d-flex justify-content-center">
                    <h2 class="text-center">{{ $login_title }}</h2>
                </div>
                @if ($is_login)
                    <div class="mt-2">Veuillez Saisir votre Email et votre mot de passe</div>
                @endif
            </div>

            @if (!$is_login)
                <div class="row mt-3">
                    <div class="col">
                        <div class="note note-primary">
                            <i class="fas fa-info-circle"></i>
                            Si vous parmi nous utilisateurs, On va vous envoyerez un email contenant un lien pour récupérer votre mot de passe.
                        </div>
                    </div>
                </div>
            @endif
            <div class="row mt-4">
                <div class="col">
                    <div class="form-outline">
                        <i class="fas fa-user-alt trailing"></i>
                        <input type="text" id="email" name="email" class="form-control {{isset($alreadyFailed)?'is-invalid':''}}" required/>
                        <label class="form-label p-1" for="email">Saisissez votre addresse e-mail</label>
                        <div class="invalid-feedback">Email que vous avez entrer est invalide</div>
                    </div>
                </div>
            </div>
            @if ($is_login)
                <div class="row">
                    <div class="col">
                        <div class="form-outline mt-3">
                            <i class="fas fa-key trailing"></i>
                            <input type="password" id="pass" name="password" class="form-control {{isset($alreadyFailed)?'is-invalid':''}}" required />
                            <label class="form-label p-1" for="pass">Saisissez votre mot de passe</label>
                            <div class="invalid-feedback">Mot de passe que vous avez entrer est invalide</div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 align-items-center justify-content-between">
                    <div class="col-xl-6 d-flex justify-content-start">
                        <a href="/restore-password">Mot de passe Oublié?</a>
                    </div>
                    <div class="col-xl-5   d-xl-flex justify-content-end">
                        <div class="form-check">
                            <input class="form-check-input" name="remember_me" type="checkbox" value="" id="flexCheckDefault" />
                            <label class="form-check-label" for="flexCheckDefault">
                                Rester Connecté
                            </label>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row mt-4">
                <div class="col d-flex justify-content-center">
                    <button class="btn btn-secondary ">
                        <h6>{{ $login_footer_btn }}</h6>
                    </button>
                </div>
                <!--
                <div class="mt-2 d-flex justify-content-center"><button type="button" class="btn btn-primary btn-wrap"
                        id="test-login">
                        <h6>TESTER LE SITE</h6>
                    </button></div>
                -->
            </div>
        </div>

    </div>

</form>
