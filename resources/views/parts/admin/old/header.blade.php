<!-- Tabs navs -->
<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
    @php
        $done = false;
    @endphp
    @foreach ($formations as  $formation => $aus)
    <li class="nav-item" role="presentation">

      <a
      class="nav-link {{$done?'':'active'}}"
      id="{{$formation}}"
      data-mdb-toggle="tab"
      href="#{{$formation}}-tab"
      role="tab"
      aria-selected="true"
      >{{$formation}}</a>
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
  @foreach($formations as $formation => $aus)
  <div class="tab-content" id="">
    <div
      class="tab-pane fade {{$done?'':'show active'}}"
      id="{{$formation}}-tab"
      role="tabpanel"
    >
      @include('parts.admin.old.au')
    </div>


  </div>
    @php
        $done = true;
    @endphp
  @endforeach
  <!-- Tabs content -->
