<div class="row">
    <!-- Tabs navs -->
    <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
        @foreach ($promotion->semestres as $key=>$semestre)
            <li class="nav-item" role="presentation">
                <a
                class="nav-link {{$key>0?'':'active'}}"
                id="tab-{{$semestre->numero."-".$promotion->numero}}"
                data-mdb-toggle="tab"
                href="#tabs-{{$semestre->numero."-".$promotion->numero}}"
                role="tab"
                aria-controls="tabs-{{$semestre->numero."-".$promotion->numero}}"
                aria-selected="true"
                >{{"Semestre ".$semestre->numero}}</a>
            </li>
        @endforeach
    </ul>
    <!-- Tabs navs -->

    <div class="tab-content" id="content">
        @if (sizeof($promotion->semestres)>0)

            @foreach ($promotion->semestres as $key=>$sem)

            <div
            class="tab-pane fade {{$key>0?'':'show active'}}"
            id="tabs-{{$sem->numero."-".$promotion->numero}}"
            role="tabpanel"
            aria-labelledby="tab-{{$sem->numero."-".$promotion->numero}}"
            >
                @include('parts.admin.etudiant.tablenote')
            </div>

            @endforeach
        @else
            <div class="row justify-content-center">Aucune donnée à afficher</div>
        @endif

    </div>

</div>
