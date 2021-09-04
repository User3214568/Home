<script type="module" src="/javascript/add-payement.js"></script>
<?php
if(isset($paiement)){
    $route = route('paiement.update',['paiement'=>$paiement->id]);
}
else{
    $route = route('paiement.store');
}
$target = 'Paiement';

$fields = [
    ['type'=>'selection','name'=>'formation_id','selected'=>isset($paiement)?$paiement->formation_id:'','value'=>'','label'=>'Selectionner La Formation','items'=>$formations],
    ['type'=>'selection','name'=>'module_id','selected'=>isset($paiement)?$paiement->professeur_id:'','value'=>'','label'=>'Selectionner Un Professeur','items'=>[]],
    ['type'=>'text','name'=>'montant','value'=>isset($paiement)?$paiement->montant:'','label'=>'Montant'],
    ['type'=>'date','name'=>'date_payement','value'=> isset($paiement)?$paiement->date_payement:date('d-m-Y'),'label'=>'Date du Paiement'],
];

?>
@include('parts.admin.common.formulaire')
