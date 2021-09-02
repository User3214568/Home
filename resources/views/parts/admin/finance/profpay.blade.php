<script src="/javascript/paiement.js"></script>
<?php

$route = route('finance.add.payement');
$target = 'Paiement';

$fields = [
    ['type'=>'selection','name'=>'formation','value'=>'','label'=>'Selectionner La Formation','items'=>$formations],
    ['type'=>'selection','name'=>'module','value'=>'','label'=>'Selectionner Un Module','items'=>[]],
    ['type'=>'text','name'=>'prof','value'=>'','label'=>'Nom et Prénom du Professeur'],
    ['type'=>'text','name'=>'montant','value'=>'','label'=>'Montant'],
    ['type'=>'date','name'=>'date_payement','value'=> date('d-m-Y'),'label'=>'Date du Paiement'],
];

?>
@include('parts.admin.common.formulaire')
