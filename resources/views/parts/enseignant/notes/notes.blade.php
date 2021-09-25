<!-- Tabs navs -->
<ul class="nav nav-tabs nav-pills nav-justified mb-3" id="ex1" role="tablist">
    @php $done  = false; @endphp
    @foreach ($professeurs as $formation=>$modules)
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $done ? '' : 'active' }}" id="{{$formation }}" data-mdb-toggle="tab"
                href="#tab-{{ str_replace(' ','',$formation) }}" role="tab" aria-selected="true">{{ $formation }}</a>
        </li>
        @php $done  = true; @endphp
    @endforeach

</ul>
<!-- Tabs navs -->

<!-- Tabs content -->
<div class="tab-content" id="ex2-content">
    @php $done  = false; @endphp
    @foreach ($professeurs as $formation=>$modules)
        <div class="tab-pane fade {{$done?'':'show active'}}" id="tab-{{ str_replace(' ','',$formation) }}" role="tabpanel">
            @include('parts.enseignant.notes.modules')
        </div>
        @php $done  = true; @endphp
    @endforeach

</div>
<!-- Tabs content -->
