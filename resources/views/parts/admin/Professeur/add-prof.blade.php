<script type="module" src="/javascript/add-prof.js"></script>
<?php

$route = route('professeur.store');
$target = 'Professeur';

$fields = [
    ['type'=>'selection','name'=>'formation_id','value'=>'','label'=>'Selectionner La Formation','items'=>$formations],
    ['type'=>'selection','name'=>'module_id','value'=>'','label'=>'Selectionner Un Module','items'=>[]],
    ['type'=>'text','name'=>'name','value'=>'','label'=>'Nom et Prénom du Professeur'],
    ['type'=>'text','name'=>'somme','value'=>'','label'=>'Somme'],
];

?>
@include('parts.admin.common.formulaire')
