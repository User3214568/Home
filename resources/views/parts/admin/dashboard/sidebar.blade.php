<div class="col-md-3">
    <div class="d-flex align-items-center flex-column">
        <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" class="rounded-circle p-3" height="150" alt=""/>
        <h5 class=""><strong>{{Auth::user()->first_name}} {{" "}} {{Auth::user()->last_name}}</strong></h5>
        <p class="text-muted">{{Auth::user()->email}}</p>
    </div>
    @foreach($items as $item)
    @if($item['expanded'])
    <a href="#" class="row text-reset p-2 sidebar-item "  data-mdb-toggle="collapse" data-mdb-target="{{ "#".$item['title'] }}" aria-expanded="false">
        <div class="col-10">
            <i class="{{ $item['icon']}}"></i>
            <span class="ms-2">{{ $item['title'] }}</span>
        </div>
        @if($item['expanded'])
        <i class="col-2 fas fa-angle-right align-self-center" onclick="sidebarArrowToggle(this)"></i>
        @endif
    </a>
    <div class="collapse ms-5" id="{{ $item['title'] }}">
        @foreach ($item['sub_items'] as $sub_item)
        <div class="sub-item p-1">
            <a href="" class="text-reset">{{$sub_item}}</a>
        </div>
        @endforeach

    </div>

    @else
    <a href="#" class="row text-reset p-2 sidebar-item"  >
        <div class="col ">
            <i  class="fas fa-home"></i>
            <span class="ms-2">{{ $item['title'] }}</span>
        </div>
        <i class="col-2 {{ $item['icon']}}"></i>
    </a>
    @endif
    @endforeach
    <div><hr class="dropdown-divider"></div>
    <a href="#" class="row text-reset p-2 sidebar-item"  >
        <div class="col -6">
            <i  class="fas fa-user-edit"></i>
            <span class="ms-2">Editer Mon Profile</span>
        </div>

    </a>
    <a href="#" class="row text-reset p-2 sidebar-item active"  >
        <div class="col -6">
            <i  class="fas fa-sign-out-alt"></i>
            <span class="ms-2">Se Déconnecter</span>
        </div>

    </a>
</div>
