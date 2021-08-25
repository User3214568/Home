<?php

    $route = route("user.store");
    if(isset($user)){
        $route = route("user.update",$user);
    }
    $fields = [
        ['type'=>'text', 'name'=>'first_name' ,'value' => isset($user)?$user->first_name:'' , 'label'=>'Nom'],
        ['type'=>'text', 'name'=>'last_name' ,'value' => isset($user)?$user->last_name:'', 'label'=>'Prenom'],
        ['type'=>'text', 'name'=>'cin' ,'value' => isset($user)?$user->cin:'', 'label'=>'Numéro de la crate d\'identité national'],
        ['type'=>'text', 'name'=>'email' ,'value' => isset($user)?$user->email:'', 'label'=>'L\'email de L\'Utilisateur'],
        ['type'=>'password','name'=>'password' ,'value' =>'','label'=>'Mot de Passe de l\'Utilisateur'],
        ['type'=>'tel', 'name'=>'phone' ,'value' => isset($user)?$user->phone:'', 'label'=>'Numéro de Téléphone'],
    ];
    $target = "Utilisateur";
    ?>
@include('parts.admin.common.formulaire')


