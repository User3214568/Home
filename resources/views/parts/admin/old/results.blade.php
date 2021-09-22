<!-- Tabs navs -->
<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
    @php
        $done = false;
    @endphp
    @if (isset($histories[0]))
        @foreach($histories[0]->getModules() as  $module)
            <li class="nav-item" role="presentation">
            <a
            class="nav-link {{$done?'':'active'}}"
            id="mod{{$module->id}}"
            data-mdb-toggle="tab"
            href="#mod{{$module->id}}-tab"
            role="tab"
            aria-selected="true"
            >{{$module->name}}</a>
            </li>
            @php
                $done = true;
            @endphp
        @endforeach
        <li class="nav-item" role="presentation">
            <a
            class="nav-link "
            id="all"
            data-mdb-toggle="tab"
            href="#all-tab"
            role="tab"
            aria-selected="true"
            >Résultats Finaux</a>
        </li>
    @endif

  </ul>
  <!-- Tabs navs -->
  @php
      $done = false;
  @endphp
 <div class="tab-content" id="">
    @if(isset($histories[0]))

        @foreach($histories[0]->getModules() as  $module)
                <div
                class="tab-pane fade {{$done?'':'show active'}}"
                id="mod{{$module->id}}-tab"
                role="tabpanel"
                >
                @include('parts.admin.old.module-result')
            </div>


            @php
                $done = true;
            @endphp
        @endforeach
        <div
                    class="tab-pane fade "
                    id="all-tab"
                    role="tabpanel"
        >
            @include('parts.admin.old.all-result')
        </div>
    @endif
</div>
  <!-- Tabs content -->
