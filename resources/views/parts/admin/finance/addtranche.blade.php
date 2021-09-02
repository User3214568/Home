
<?php
    $route = route('finance.add.tranch.post');
    $target = 'Tranche';
    $adj = 'Une Nouvelle';
    $fields = [
        ['type'=>'text','name'=>'etudiant_cin','value'=>'','label'=>'Le Numéro du CIN de L\'Etudiant'],
        ['type'=>'text','name'=>'vers','value'=>'','label'=>'Le Montant Versé'],
        ['type'=>'text','name'=>'ref','value'=>'','label'=>'Référence du Versement'],
        ['type'=>'date','name'=>'date_vers','value'=> date('d-m-Y'),'label'=>'Date du Versement'],
        ['type'=>'checkbox','name'=>'proved','value'=>'','label'=>'Versement Vérifier'],
    ];

?>
@include('parts.admin.common.formulaire')
