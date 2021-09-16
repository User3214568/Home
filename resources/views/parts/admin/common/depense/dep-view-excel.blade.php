<style>
    .header {
        background-color: orange;
        color: white;
    }

</style>
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

    <tr>
        <th colspan="3" style="background-color : orange;color: white;font-size : 14px;border :1px solid black">Dépenses</th>
    </tr>
    <tr>
        <th colspan="2" style="font-size : 13px ; border:1px solid black">Motif</th>
        <th colspan="1" style="font-size : 13px ; border:1px solid black">Somme</th>
    </tr>
    @foreach ($motifs as $motif)
        <tr class="border:1px solid orange">
            <td colspan="2" style="border:1px solid black">{{ $motif->name }}</td>
            <td colspan="1" style="border:1px solid black">{{ $motif->somme }}</td>
            <?php $total += $motif->somme; ?>
        </tr>
    @endforeach
    <tr>
        <th colspan="1" style="border:1px solid black">Total</th>
        <th  colspan="2" style="border:1px solid black">{{ $total }}</th>
    </tr>
</table>
<table>
    <tr>
        <th colspan="3" style="background-color : orange;color: white;font-size : 14px;border :1px solid black">Effectifs et Répartition</th>
    </tr>
    <tr>
        <th style="font-size : 13px ; border:1px solid black">Formation</th>
        <th style="font-size : 13px ; border:1px solid black">Effectif</th>
        <th style="font-size : 13px ; border:1px solid black">Part</th>
    </tr>
    @foreach ($formations as $formation)
        <tr>
            <td style="border:1px solid black">{{ $formation->name }}</td>
            <td style="border:1px solid black">{{ $formation->getEffectif() }}</td>
            <td style="border:1px solid black">{{ $total_effectif == 0 ? 0 : ($total * $formation->getEffectif()) / $total_effectif }}</td>
        </tr>
    @endforeach
</table>


