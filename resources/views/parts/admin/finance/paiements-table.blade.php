<?php $paiements = App\Paiement::get()
    ->where('formation_id', $id)
    ->groupBy('date_payement');
$size = sizeof($paiements);

?>
<table>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
</table>
@foreach ($paiements as $date => $coll_paiements)
<?php $total = 0; ?>
<table>

    <tr></tr>
        <tr>
            <td  colspan="3" style="font-family : 'Times New Roman';border : 1px solid black ; text-align : center; font-size : 14px" ><strong>Paiement des Professeurs, LE {{$date}}</strong></td>
        </tr>
        <tr>
            <td style="font-family : 'Times New Roman';border : 1px solid black ; text-align : center; font-size:13px ;  background-color : yellow">Module</td>
            <td style="font-family : 'Times New Roman';border : 1px solid black ; text-align : center; font-size:13px ;  background-color : yellow">Professeur</td>
            <td style="font-family : 'Times New Roman';border : 1px solid black ; text-align : center; font-size:13px ;  background-color : yellow">Montant</td>
        </tr>
        <tbody>

            @foreach ($coll_paiements as $paiement)
            <tr>

                <td style="font-family : 'Times New Roman';border : 1px solid black ; text-align : center ; font-size : 13px">{{$paiement->professeur->module->name}}</td>
                <td style="font-family : 'Times New Roman';border : 1px solid black ; text-align : center ; font-size : 13px">{{$paiement->professeur->name}}</td>
                <td style="font-family : 'Times New Roman';border : 1px solid black ; text-align : center ; font-size : 13px">{{$paiement->montant}}</td>
            </tr>
            <?php $total+= $paiement->montant; ?>
            @endforeach
            <tr>
                <td colspan="1" style="font-family : 'Times New Roman';border : 1px solid black ; text-align : center; font-size:13px ; font-weight : bold ; background-color : skyblue">Total Paiement</td>
                <td colspan="2" style="font-family : 'Times New Roman';border : 1px solid black ; text-align : center; font-size:13px ; font-weight : bold ; background-color : skyblue">{{$total}}</td>
            </tr>
        </tbody>

</table>
@endforeach
