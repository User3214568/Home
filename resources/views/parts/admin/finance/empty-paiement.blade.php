
<table>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <thead>
        <tr>
            <td style="font-size: 14px;font-weight: bold;background-color: orange; border : 1px solid black" colspan="1">Date</td>
            <td style="font-size: 14px;font-weight: bold;background-color: orange; border : 1px solid black" colspan="1"></td>
        </tr>
        <tr>
            <td style="font-size: 14px;font-weight: bold;background-color: skyblue ; border : 1px solid black" >Professeur</td>
            <td style="font-size: 14px;font-weight: bold;background-color: skyblue ; border : 1px solid black" >Montant</td>
        </tr>
    </thead>
    @foreach ($formation->professeurs as $prof)
    <tr>
        <td style="font-size: 13px;font-family: 'arial'; border : 1px solid black">{{$prof->teacher->name}}</td>
        <td style="font-size: 13px;font-family: 'arial'; border : 1px solid black"></td>
    </tr>
    @endforeach
</table>
