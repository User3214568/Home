<div class="row">
    <h2>Dépenses Communes</h2>
    <hr class="dropdown-divider">
</div>
<div class="row justify-content-end">
    <a href="{{route('depense.create')}}" class="btn btn-primary btn-floating"></a>
</div>
<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Motif</th>
                <th>Somme</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($motifs as $motif)
                <tr>
                    <td>{{$motif->name}}</td>
                    <td>{{$motif->somme}}</td>
                    <?php $total += $motif->somme; ?>
                </tr>
            @endforeach
            <tr class="table-dark">
                <th>Total</th>
                <th>{{$total}}</th>
            </tr>
        </tbody>
    </table>
</div>
