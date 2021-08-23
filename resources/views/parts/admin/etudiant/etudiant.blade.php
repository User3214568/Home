<?php
    $route = "/etudiant";
    if(isset($etudiant)){
        $route = route("etudiant.update",$etudiant);
    }

    $fields = [
        ['type'=>'text', 'name'=>'first_name' ,'value' => isset($etudiant)?$etudiant->first_name:'' , 'label'=>'Nom'],
        ['type'=>'text', 'name'=>'last_name' ,'value' => isset($etudiant)?$etudiant->last_name:'', 'label'=>'Prenom'],
        ['type'=>'text', 'name'=>'cin' ,'value' => isset($etudiant)?$etudiant->cin:'', 'label'=>'Numéro de la crate d\'identité national'],
        ['type'=>'text', 'name'=>'cne' ,'value' => isset($etudiant)?$etudiant->cne:'' ,'label'=>'Code  Massar'],
        ['type'=>'text', 'name'=>'email' ,'value' => isset($etudiant)?$etudiant->email:'', 'label'=>'L\'email de L\' Etudiant'],
        ['type'=>'selection','name'=>'formation_id' ,'value' => isset($etudiant)?$etudiant->formation_id:'','label'=>'Formation de L\' Etudiant','items'=> $formations],
        ['type'=>'date', 'name'=>'born_date' ,'value' => isset($etudiant)?$etudiant->born_date:'', 'label'=>'Date de Naissance'],
];
    $target = "Etudiant";
    ?>
@include('parts.admin.etudiant.formulaire')


