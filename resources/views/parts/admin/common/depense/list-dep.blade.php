<script src="/javascript/depenses.js"></script>


<div class="row">
    <h2>Dépenses Communes</h2>
    <hr class="dropdown-divider">
</div>


<!-- Tabs navs -->
<ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="ex1-tab-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab"
            aria-controls="ex1-tabs-1" aria-selected="true">Dépenses</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="ex1-tab-2" data-mdb-toggle="tab" href="#ex1-tabs-2" role="tab"
            aria-controls="ex1-tabs-2" aria-selected="false">Répartition des Dépenses sur les formations </a>
    </li>

</ul>
<!-- Tabs navs -->

<!-- Tabs content -->
<div class="tab-content" id="ex1-content">
    <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
        <div class="row ">
            @if (isset($errors) && sizeof($errors->all())>0)
            <div class="col p-3 note note-danger">
                <ul>

                    @foreach ($errors->all() as $err)
                    <li>
                        {{$err}}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        <div class="">
            <form class="d-flex justify-content-end" action="{{ route('depense.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <button id="submit" type="submit" hidden></button>
                <input id="upload-input" type="file" name="file" hidden>
                <button id="upload" type="button" class="btn btn-success btn-floating">
                    <i class="fas fa-upload"></i>
                </button>
                <a href="{{ route('depense.create') }}" class="btn btn-primary btn-floating">
                    <i class="fas fa-plus"></i>
                </a>
                <a href="{{ route('depense.export', ['type' => 'false']) }}" class="btn btn-danger btn-floating">
                    <i class="fas fa-download"></i>
                </a>
                <a href="{{ route('depense.export', ['type' => 'true']) }}" class="btn btn-dark btn-floating">
                    <i class="fas fa-download"></i>
                </a>
            </form>

        </div>
        <div class="table-responsive mt-4">

            <table class="table table-bordered table-sm align-middle text-center text-nowrap ">
                <thead>
                    <tr>

                    </tr>
                    <tr>
                        <th>Motif</th>
                        <th>Somme</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (sizeof($motifs) > 0)
                        @foreach ($motifs as $motif)
                            <tr>
                                <td>{{ $motif->name }}</td>
                                <td>{{ $motif->somme }}</td>
                                <td>
                                    <form action="{{ route('depense.destroy', $motif) }}" method="POST"
                                        class="row justify-content-center">
                                        @csrf
                                        @method('delete')
                                        <a href="{{ route('depense.edit', ['depense' => $motif]) }}"
                                            class="btn btn-floating">
                                            <i class="fas fa-pen-square fa-2x"></i>
                                        </a>
                                        <button class=" btn btn-floating">
                                            <i class="fas fa-times-circle fa-2x"></i>
                                        </button>
                                    </form>
                                </td>
                                <?php $total += $motif->somme; ?>
                            </tr>
                        @endforeach
                        <tr class="table-dark">
                            <th colspan="1">Total</th>
                            <th colspan="2">{{ $total }}</th>
                        </tr>
                    @else
                        <td colspan="3">Aucune dépense à afficher.</td>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
        <script>
            var for_eff = {!! $formations_effectifs !!}
            var total = {!! json_encode($total_eff) !!}
        </script>
        <div class="row align-items-center">
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Formation</th>
                            <th>Effectif</th>
                            <th>Part</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (json_decode($formations_effectifs) as $key => $f_eff)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $f_eff }}</td>
                                <td>{{ $total_eff > 0 ? number_format($total*$f_eff / $total_eff,2): '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 d-flex justify-content-center align-items-center" id="chart"></div>
        </div>
    </div>

</div>
<!-- Tabs content -->
