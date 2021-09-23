
<style>
    .header{
        height : 25px;
        font-size: 20px;
        border-bottom: 1px solid black;
        color : rgb(0, 0, 0);
    }
    .title{
        font-size: 13px
    }
    span{
        font-size: 14px !important;
    }
</style>

<div class="header">
    <p style=""> Gestionnaire des Formations</p>
</div>
<div class="title">
    <span>

        <strong>
            Bonjour {{$user->first_name." ".$user->last_name}}
        </strong>
    </span>
</div>
<br>
<div class="title" style='font-size : 12px'>
    <span>
        Nous avons reçu votre tentative de récupération de votre compte.
        Pour acceder à votre compte veuillez utiliser la lien suivant :
        <a href="{{$token}}">{{$token}}</a>
    </span>

</div>
