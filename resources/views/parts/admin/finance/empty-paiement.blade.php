
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
            <td style="font-size: 14px;font-weight: bold;background-color: orange; border : 1px solid black" colspan="2">Date</td>
            <td style="font-size: 14px;font-weight: bold;background-color: orange; border : 1px solid black" colspan="1"></td>
        </tr>
        <tr>
            <td  colspan="2" style="font-size: 14px;font-weight: bold;background-color: skyblue ; border : 1px solid black" >Professeur</td>
            <td style="font-size: 14px;font-weight: bold;background-color: skyblue ; border : 1px solid black" >Montant</td>
        </tr>
    </thead>
    @foreach ($formation->teachers() as $teacher)
    <tr>
        <td style="font-size: 13px;font-family: 'arial'; border : 1px solid black">{{$teacher->id}}</td>
        <td style="font-size: 13px;font-family: 'arial'; border : 1px solid black">{{$teacher->first_name." ".$teacher->last_name}}</td>
        <td style="font-size: 13px;font-family: 'arial'; border : 1px solid black"></td>
    </tr>
    @endforeach
</table>
