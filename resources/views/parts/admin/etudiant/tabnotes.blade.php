<script src="/javascript/module-note.js"></script>
<script src="/javascript/evaluation.js"></script>
<h5 class="mt-5">Notes Des Etudiants</h5>
<div class="row mt-1"><hr class="dropdown-divider"></div>
@if(isset($result))

<div class="row justify-content-around">
    <a  href="{{route('etudiant.notes.export',['id'=>$formation->id])}}" class="col-6 btn btn-success">
        Exporter Les Résultats Finaux du Formation {{$formation->name}}
    </a>
</div>
<div class="row mt-1"><hr class="dropdown-divider"></div>
@endif
<div class="row  p-1 mt-1">
    <!-- Tabs navs -->
    <ul class="nav  nav-tabs nav-justified mb-3 " id="ex1" role="tablist">
        @foreach ($formation->promotions->sortBy('numero') as $key=>$promo)
            <li name="triggers-promo" class="nav-item" role="presentation">
                <a
                class="nav-link {{$promo->numero > 1 ? ' ' : 'active'}}"
                id="tab-{{$promo->numero}}"
                data-mdb-toggle="tab"
                href="#tabs-{{$promo->numero}}"
                role="tab"
                aria-controls="tabs-{{$promo->numero}}"
                aria-selected="true"
                >{{$promo->nom}}</a>
            </li>
        @endforeach
    </ul>
    <!-- Tabs navs -->

    <div class="tab-content" id="content">
            @foreach ($formation->promotions as $key=>$promotion)
                <div
                    class="tab-pane fade {{$promotion->numero > 1 ? ' ':'show active'}}"
                    id="tabs-{{$promotion->numero}}"
                    role="tabpanel"
                    aria-labelledby="tab-{{$promotion->numero}}"
                >
                    @include('parts.admin.etudiant.semestrenote')
                </div>

            @endforeach

    </div>
    @include('parts.admin.common.modal')
</div>

