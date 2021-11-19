<?php
    $route = route("etudiant.store");
    if(isset($etudiant)){
        $route = route("etudiant.update",$etudiant);
    }


    $fields = [
        ['type'=>'text', 'name'=>'first_name' ,'value' => isset($etudiant)?$etudiant->user->first_name:'' , 'label'=>'Nom'],
        ['type'=>'text', 'name'=>'last_name' ,'value' => isset($etudiant)?$etudiant->user->last_name:'', 'label'=>'Prenom'],
        ['type'=>'text', 'name'=>'email' ,'value' => isset($etudiant)?$etudiant->user->email:'', 'label'=>'L\'email de L\' Etudiant'],
        ['type'=>'selection','name'=>'formation_id','selected'=>isset($etudiant)?$etudiant->formation_id:'' ,'value' => isset($etudiant)?$etudiant->formation_id:'','label'=>'Formation de L\' Etudiant','items'=> $formations],
        ['type'=>'date', 'name'=>'born_date' ,'value' => isset($etudiant)?$etudiant->born_date:'', 'label'=>'Date de Naissance'],
        ['type'=>'text', 'name'=>'born_place' ,'value' => isset($etudiant)?$etudiant->born_place:'' ,'label'=>'Lieu de Naissance'],
        ['type'=>'text', 'name'=>'phone' ,'value' => isset($etudiant)?$etudiant->user->phone:'' ,'label'=>'Numéro de Téléphone','required'=>false],
    ];
    if(isset($etudiant)){
        array_push($fields,['type'=>'selection','name'=>'promotion_id' ,'selected'=>$etudiant->promotion_id,'value' => $etudiant->promotion_id,'label'=>'Promotion de L\' Etudiant','items'=> $promotions]);
    }else{
        array_push($fields,['type'=>'text', 'name'=>'cin' ,'value' => isset($etudiant)?$etudiant->cin:'', 'label'=>'Numéro de la crate d\'identité national']);
    }

    $target = "Etudiant";
    ?>
@include('parts.admin.common.formulaire')


