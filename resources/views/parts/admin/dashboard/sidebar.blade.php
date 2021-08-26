<div class="col-md-3"  id="mysidebar">
    <div class="row justify-content-center " style="width : 60px" id="sidebartoggler">
        <button class="btn btn-primary btn-floating">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="d-flex align-items-center flex-column">
        <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" class="rounded-circle p-3" height="150" alt="" name="side-item-label"/>
        <h5 class=""><span name="side-item-label"><strong>{{Auth::user()->first_name}} {{" "}} {{Auth::user()->last_name}}</strong></span></h5>
        <p class="text-muted"><span name="side-item-label">{{Auth::user()->email}}</span></p>
    </div>
    @foreach($items as $item)
    @if($item['expanded'])
        <a href="#" class="row text-reset p-2 sidebar-item "   data-mdb-toggle="collapse" data-mdb-target="{{ "#".$item['title'] }}" aria-expanded="false">
            <div class="col-10">
                <i class="{{ $item['icon']}}" ></i>
                <span class="ms-2" name="side-item-label">{{ $item['title'] }}</span>
            </div>
            <i class="col-2 fas fa-angle-right align-self-center" name="side-item-label" onclick="sidebarArrowToggle(this)"></i>
        </a>
        <div class="collapse ms-5" id="{{ $item['title'] }}">
            @foreach ($item['sub_items'] as $sub_item)
            <div class="sub-item p-1">
                <a href="{{$sub_item['link']}}" class="row text-reset">
                    <i class="col-1 {{$sub_item['icon']}}"></i>
                    <span class="col-10 " name="side-item-label">{{$sub_item['title']}}</span>
                </a>
            </div>
            @endforeach
        </div>
    @else
        <a href="{{isset($item['link'])?$item['link']:''}}" class="row text-reset p-2 sidebar-item"  >
            <div class="col ">
                <i  class="{{$item['icon']}}"></i>
                <span class="ms-2" name="side-item-label">{{ $item['title'] }}</span>
            </div>
        </a>
    @endif
    @endforeach
    <div><hr class="dropdown-divider"></div>
    <a href="#" class="row text-reset p-2 sidebar-item"  >
        <div class="col -6">
            <i  class="fas fa-user-edit"></i>
            <span class="ms-2" name="side-item-label">Editer Mon Profile</span>
        </div>

    </a>
    <a href="#" class="row text-reset p-2 sidebar-item active"  >
        <div class="col -6">
            <i  class="fas fa-sign-out-alt"></i>
            <span class="ms-2" name="side-item-label">Se Déconnecter</span>
        </div>

    </a>
</div>
