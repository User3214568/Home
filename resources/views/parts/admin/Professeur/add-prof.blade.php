<script type="module" src="/javascript/add-prof.js"></script>
<?php

$route = route('professeur.store');
$target = 'Professeur';

$fields = [
    ['type'=>'selection','name'=>'formation_id','value'=>'','label'=>'Selectionner La Formation','items'=>$formations],
    ['type'=>'selection','name'=>'module_id','value'=>'','label'=>'Selectionner Un Module','items'=>[]],
    ['type'=>'selection','name'=>'teacher_id','value'=>'','label'=>'Selectionner un professeur','items'=>$teachers],
    ['type'=>'text','name'=>'somme','value'=>'','label'=>'Somme'],
];

?>
@include('parts.admin.common.formulaire')
