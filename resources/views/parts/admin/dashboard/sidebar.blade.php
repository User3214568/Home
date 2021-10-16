<div class="col-md-3 " id="mysidebar">
    <div class="position-fixed d-flex justify-content-center align-items-center" style="width : 60px" id="sidebartoggler">
        <button class="d-none d-md-block btn btn-primary btn-floating ">
            <i name="icon-sidebar" class="fas fa-bars"></i>
        </button>
        <button id="sidebarHideToggler" class="d-block d-md-none ms-1 btn btn-primary btn-floating ">
            <i class="fas fa-angle-up"></i>
        </button>
    </div>
    <div id="side">

        <div class="mt-5 d-flex align-items-center flex-column">
            <img name="side-item-label" src="{{ url(route('avatar', ['cin' => Auth::user()->cin])) }}" class="rounded-circle p-3" height="150"
                alt="" />
            <h5 class=""><span name=" side-item-label"><strong><span
                        name="side-item-label">{{ Auth::user()->first_name }} {{ ' ' }}
                        {{ Auth::user()->last_name }}</span></strong></span></h5>
            <p class="text-muted"><span name="side-item-label">{{ Auth::user()->email }}</span></p>
        </div>
        @foreach ($items as $item)
            @if (isset($item['divider']))
                <div class="border-top pt-2 row">
                    <span name="side-item-label">
                        <h6>{{ $item['title'] }}</h6>
                    </span>
                </div>
            @else
                @if ($item['expanded'])
                    <a href="#" class="row text-reset p-2 sidebar-item " data-mdb-toggle="collapse"
                        data-mdb-target="{{ '#' . $item['title'] }}" aria-expanded="false">
                        <div class="col-10">
                            <i name="icon-sidebar" class="{{ $item['icon'] }}"></i>
                            <span class="ms-2" name="side-item-label">{{ $item['title'] }}</span>
                        </div>
                        <i class="col-2 fas fa-angle-right align-self-center" name="side-item-label"
                            onclick="sidebarArrowToggle(this)"></i>
                    </a>
                    <div class="collapse ms-3" id="{{ $item['title'] }}">
                        @foreach ($item['sub_items'] as $sub_item)
                            <div class="sub-item p-1">
                                <a href="{{ $sub_item['link'] }}" class="row text-reset">
                                    <i name="icon-sidebar" class="col-1 {{ $sub_item['icon'] }}"></i>
                                    <span class="col-10 "
                                        name="side-item-label">{{ $sub_item['title'] }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <a href="{{ isset($item['link']) ? $item['link'] : '' }}"
                        class="row text-reset p-2 sidebar-item">
                        <div class="col ">
                            <i name="icon-sidebar" class="{{ $item['icon'] }}"></i>
                            <span class="ms-2" name="side-item-label">{{ $item['title'] }}</span>
                        </div>
                    </a>
                @endif
            @endif
        @endforeach
        <div>
            <hr class="dropdown-divider">
        </div>
        <a href="{{route('user.edit',Auth::user()->cin)}}" class="row text-reset p-2 sidebar-item">
            <div class="col -6">
                <i  name="icon-sidebar" class="fas fa-user-edit"></i>
                <span class="ms-2" name="side-item-label">Editer Mon Profile</span>
            </div>

        </a>
        <a href="{{route('logout')}}" class="row text-reset p-2 sidebar-item active">
            <div class="col -6">
                <i name="icon-sidebar" class="fas fa-sign-out-alt"></i>
                <span class="ms-2" name="side-item-label">Se Déconnecter</span>
            </div>

        </a>
    </div>
</div>
