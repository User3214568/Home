<form class="container mt-5 p-1" method="post" action="/login">
    {{ csrf_field() }}
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="row">
                <div class="col d-flex justify-content-center"><h2>{{$login_title}}</h2></div>
            </div>
            @if(!$is_login)
            <div class="row mt-3">
                <div class="col">
                    <div class="note note-primary">
                        <i class="fas fa-info-circle"></i>
                        On va vous envoyerez un email contenant un lien pour récupérer votre mot de passe.
                    </div>
                </div>
            </div>
            @endif
            <div class="row mt-4">
                <div class="col">
                    <div class="form-outline">
                        <i class="fas fa-user-alt trailing"></i>
                        <input type="text" id="form1" name="email" class="form-control" />
                        <label class="form-label p-1" for="form1">Saisissez votre addresse e-mail</label>
                    </div>
                </div>
            </div>
            @if($is_login)
            <div class="row">
                <div class="col">
                    <div class="form-outline mt-3">
                        <i class="fas fa-key trailing"></i>
                        <input type="password" id="form1" name="password" class="form-control" />
                        <label class="form-label p-1" for="form1">Saisissez votre mot de passe</label>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col d-flex justify-content-start" >
                    <a href="/restore-password">Mot de passe Oubliée?</a>
                </div>
            </div>
            @endif

            <div class="row mt-5">
                <div class="col d-flex justify-content-center"><button class="btn btn-primary btn-wrap"><h6>{{$login_footer_btn}}</h6></button></div>
            </div>
        </div>
    </div>
</form>
