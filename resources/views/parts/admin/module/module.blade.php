<?php
    $route = route('module.store');
    if(isset($module)){
        $route = route('module.update',$module->id);
    }
    $fields = [
        ['type'=>'text', 'name'=>'name' ,'value' => isset($module)?$module->name:'' , 'label'=>'Nom du Module'],
        ['type'=>'textarea', 'name'=>'description' ,'value' => isset($module)?$module->description:'', 'label'=>'Description du Module'],
    ];
    $target = 'Module';

?>
@include('parts.admin.common.formulaire')
