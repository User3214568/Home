<div class="row  p-1 mt-1">
    <!-- Tabs navs -->
    <ul class="nav  nav-tabs nav-justified mb-3 " id="ex1" role="tablist">
        @foreach ($formation->promotions->sortBy('numero') as $key=>$promo)
            <li class="nav-item" role="presentation">
                <a
                class="nav-link {{$key>0?'':'active'}}"
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
                    class="tab-pane fade {{$key>0?'':'show active'}}"
                    id="tabs-{{$promotion->numero}}"
                    role="tabpanel"
                    aria-labelledby="tab-{{$promotion->numero}}"
                >
                    @include('parts.admin.etudiant.delib-table')
                </div>

            @endforeach

    </div>
    @if(sizeof($formation->promotions) < 1 )
    <p class="text-center">La formation {{$formation->name}} n' a aucune promotion à afficher</>
    @endif
</div>
