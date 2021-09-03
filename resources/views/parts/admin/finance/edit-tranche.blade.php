
<?php
$route = route('tranche.update',['tranche'=>$tranche->id]);
$target = 'Tranche';

$fields = [
    ['type'=>'text','name'=>'etudiant_cin','value'=>$tranche->etudiant->cin,'label'=>'Le Numéro du CIN de L\'Etudiant'],
    ['type'=>'text','name'=>'vers','value'=>$tranche->vers,'label'=>'Le Montant Versé'],
    ['type'=>'text','name'=>'ref','value'=>$tranche->ref,'label'=>'Référence du Versement'],
    ['type'=>'date','name'=>'date_vers','value'=> $tranche->date_vers,'label'=>'Date du Versement'],
    ['type'=>'checkbox','name'=>'proved','checked'=>$tranche->proved,'label'=>'Versement Vérifier'],
];

?>
@include('parts.admin.common.formulaire')
