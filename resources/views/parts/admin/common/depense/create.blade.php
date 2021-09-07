
<?php
    $route = route('depense.store');
    if(isset($motif)){
        $route = route('depense.update',$motif);
    }


    $fields = [
        ['type'=>'text', 'name'=>'name' ,'value' => isset($motif)?$motif->name:'' , 'label'=>'Motif'],
        ['type'=>'text', 'name'=>'somme' ,'value' => isset($motif)?$motif->somme:'', 'label'=>'Somme'],

    ];


    $target = "Dépense";
    ?>
@include('parts.admin.common.formulaire')




?>
