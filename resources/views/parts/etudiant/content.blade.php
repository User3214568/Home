<div class="row m-1 justify-content-between" >
    @include('parts.admin.dashboard.sidebar')
    <div class="col-md-9 " id="admin-content">
        @if(!isset($content))

        @else
            @include($content)
        @endif

    </div>
</div>
