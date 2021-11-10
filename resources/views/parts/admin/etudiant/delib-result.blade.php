@if(!$pass)
    <form method="POST" action="{{route('etudiant.finaliser')}}" class="row justify-content-end">
        @csrf
        <input type="text" value="" id="results-obj" name="results" hidden>
        <button type="submit" id="submit-result" hidden></button>
        <button type="button" id="syn-submit" class="btn btn-primary ">Confirmer les Résultats du Fin d'Année</button>
    </form>
@else
    <div class="row border p-5">
        Vous avez déja fait la délibration des résultats des étudiants de cet formation.
    </div>
@endif
<div class="row  p-1 mt-1">
    <!-- Tabs navs -->
    <ul class="nav  nav-tabs nav-justified mb-3 " id="ex1" role="tablist">
        @php $done = false; @endphp
        @foreach ($formation->promotions->sortBy('numero') as $key=>$promo)
            <li class="nav-item" role="presentation">
                <a
                class="nav-link {{$done?'':'active'}}"
                id="tab-{{$promo->numero}}"
                data-mdb-toggle="tab"
                href="#tabs-{{$promo->numero}}"
                role="tab"
                aria-controls="tabs-{{$promo->numero}}"
                aria-selected="true"
                >{{$promo->nom}}</a>
            </li>
            @php $done = true; @endphp
        @endforeach
    </ul>
    <!-- Tabs navs -->

    <div class="tab-content" id="content">
        @php $done = false; @endphp
            @foreach ($formation->promotions->sortBy('numero') as $key=>$promotion)
                <div
                    class="tab-pane fade {{$done?'':'show active'}}"
                    id="tabs-{{$promotion->numero}}"
                    role="tabpanel"
                    aria-labelledby="tab-{{$promotion->numero}}"
                >
                    @include('parts.admin.etudiant.delib-table')
                </div>
                @php $done = true; @endphp
            @endforeach

    </div>
    @if(sizeof($formation->promotions) < 1 )
    <p class="text-center">La formation {{$formation->name}} n' a aucune promotion à afficher</>
    @endif
</div>
