<!-- Tabs navs -->
<script src="/javascript/module-note.js"></script>
<script type="module" src="/javascript/notes.js"></script>
<script src="/javascript/evaluation.js"></script>
<div class="row">
    <h2>Note des Etudiants</h2>
</div>
<ul class="nav nav-tabs nav-pills nav-justified mb-3" id="ex1" role="tablist">
    @php $done  = false; @endphp
 
   
        @foreach ($formations as $formation)
            @if (array_key_exists($formation->id, $auth_formations))
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $done ? '' : 'active' }}" id="{{ $formation }}" data-mdb-toggle="tab"
                        href="#tab-{{ str_replace(' ', '', $formation->name) }}" role="tab"
                        aria-selected="true">{{ $formation->name }}</a>
                </li>
                @php $done  = true; @endphp
            @endif
        @endforeach
    @if(!$done)
        <div class="p-3 mt-2 justify-content-center">
            <div class="alert alert-info">Vous n'avez aucun module à afficher.</div>
        </div>
    @endif

</ul>
<!-- Tabs navs -->

<!-- Tabs content -->
<div class="tab-content" id="ex2-content">
    @php $done  = false; @endphp
    @foreach ($formations as $formation)
        @if (array_key_exists($formation->id, $auth_formations))
            @php
                $auth_modules = $auth_formations[$formation->id]
            @endphp
            <div class="tab-pane fade {{ $done ? '' : 'show active' }}" id="tab-{{ str_replace(' ', '', $formation) }}"
                role="tabpanel">
                @include('parts.enseignant.notes.notesv2')
            </div>
            @php $done  = true; @endphp
        @endif
    @endforeach
</div>
@include('parts.admin.common.modal')
<!-- Tabs content -->
