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

