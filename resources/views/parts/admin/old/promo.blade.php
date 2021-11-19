<!-- Tabs navs -->
<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
    @php
        $done = false;
    @endphp
    @foreach ($promos as $promo => $histories)
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $done ? '' : 'active' }}" id="{{ $promo }}" data-mdb-toggle="tab"
                href="#{{ $promo }}-tab" role="tab" aria-selected="true">{{ $promo }}</a>
        </li>
        @php
            $done = true;
        @endphp
    @endforeach

</ul>
<!-- Tabs navs -->
@php
$done = false;
@endphp
@foreach ($promos as $promo => $histories)
    <div class="tab-content" id="">
        <div class="tab-pane fade {{ $done ? '' : 'show active' }}" id="{{ $promo }}-tab" role="tabpanel">
            @include('parts.admin.old.notes-list')
        </div>


    </div>
    @php
        $done = true;
    @endphp
@endforeach
<!-- Tabs content -->
