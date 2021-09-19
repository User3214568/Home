@php

$route = route('teacher.store');
$target = 'Professeur';

$fields = [
    ['type'=>'text','name'=>'first_name','value'=>'','label'=>'Nom du Professeur'],
    ['type'=>'text','name'=>'last_name','value'=>'','label'=>'Prénom du Professeur'],
    ['type'=>'text','name'=>'id','value'=>'','label'=>'Code du Professeur'],
];

@endphp
@include('parts.admin.common.formulaire')
