<script type="module" src="/javascript/add-prof.js"></script>
<?php

$route = route('professeur.update',['professeur'=>$prof->id]);
$target = 'Professeur';

$fields = [
    ['type'=>'selection','selected'=>$prof->formation_id,'name'=>'formation_id','value'=>'','label'=>'Selectionner La Formation','items'=>$formations],
    ['type'=>'selection','name'=>'module_id','selected'=>$prof->module_id,'value'=>'','label'=>'Selectionner Un Module','items'=>[$prof->module]],
    ['type'=>'text','name'=>'name','value'=>$prof->name,'label'=>'Nom et Prénom du Professeur'],
    ['type'=>'text','name'=>'somme','value'=>$prof->somme,'label'=>'Somme'],
];

?>
@include('parts.admin.common.formulaire')
