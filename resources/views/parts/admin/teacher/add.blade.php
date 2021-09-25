@php

$route = route('teacher.store');
if(isset($teacher)){
    $route = route('teacher.update',['teacher'=>$teacher->id]);
}
$target = 'Professeur';

$fields = [
    ['type'=>'text','name'=>'first_name','value'=>(isset($teacher)?$teacher->user->first_name:''),'label'=>'Nom du Professeur'],
    ['type'=>'text','name'=>'last_name','value'=>(isset($teacher)?$teacher->user->last_name:''),'label'=>'Prénom du Professeur'],
    ['type'=>'text','name'=>'cin','value'=>(isset($teacher)?$teacher->user_cin:''),'label'=>'Code du Professeur'],
];

@endphp
@include('parts.admin.common.formulaire')
