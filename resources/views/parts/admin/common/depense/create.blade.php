
<?php
    $route = route('depense.store');
    if(isset($dep)){
        $route = route('depense.update',$dep);
    }


    $fields = [
        ['type'=>'text', 'name'=>'name' ,'value' => isset($dep)?$dep->name:'' , 'label'=>'Motif'],
        ['type'=>'text', 'name'=>'somme' ,'value' => isset($dep)?$dep->somme:'', 'label'=>'Somme'],
    ];


    $target = "Dépense";
?>
@include('parts.admin.common.formulaire')
