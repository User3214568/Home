<div class="row">
    <h2>Mes Résultats</h2>
    <hr class="dropdown-divider">
</div>
<div class="table-responsive">
    <table class="table table-border mt-3">
        <tr>
            <th>Module</th>
            <th>Note S. Ordinnaire</th>
            <th>Résultat S. Ordinnaire</th>
            <th>Note S. Rattrappage</th>
            <th>Résultat S. Rattrappage</th>
        </tr>
        @foreach ($modules_results as $item)
            <tr class="{{($item['result'][1]['result'] === "Validé" || $item['result'][2]['result'] === "Validé")?'text-success':'text-danger'}}">
                <th>{{$item['name']}}</th>
                <td>{{$item['result'][1]['note']}}</td>
                <td>{{$item['result'][1]['result']}}</td>
                @if ($item['result'][1]['result'] === "Validé")
                    <td>-</td>
                    <td>-</td>
                @else
                    <td>{{$item['result'][2]['note']}}</td>
                    <td>{{$item['result'][2]['result']}}</td>
                @endif
            </tr>
        @endforeach
    </table>
</div>
