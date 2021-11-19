<!-- Tabs navs -->
<ul class="nav nav-tabs  nav-justified  mb-3" id="ex1" role="tablist">
    @php $done  = false; @endphp
    @foreach ($modules as $module=>$profs)
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $done ? '' : 'active' }}" id="module-{{ $module}}" data-mdb-toggle="tab"
                href="#tab--mod-{{ str_replace(' ','',$formation).str_replace(' ','',$module) }}" role="tab" aria-selected="true">{{ $module }}</a>
        </li>
        @php $done  = true; @endphp
    @endforeach

</ul>
<!-- Tabs navs -->

<!-- Tabs content -->
<div class="tab-content" id="ex4-content">
    @php $done  = false; @endphp
    @foreach ($modules as $module=>$profs)
        <div class="tab-pane fade {{$done?'':'show active'}}" id="tab--mod-{{ str_replace(' ','',$formation).str_replace(' ','',$module) }}" role="tabpanel">
            @include('parts.enseignant.notes.sessions')
        </div>
        @php $done  = true; @endphp
    @endforeach

</div>
<!-- Tabs content -->
