<!-- Tabs navs -->
<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
    @php
        $done = false;
    @endphp
    @foreach ($aus as  $au => $promos)
    <li class="nav-item" role="presentation">

      <a
      class="nav-link {{$done?'':'active'}}"
      id="{{$au}}"
      data-mdb-toggle="tab"
      href="#{{$au}}-tab"
      role="tab"
      aria-selected="true"
      >{{$au}}</a>
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
  @foreach($aus as $au => $promos)
  <div class="tab-content" id="">
    <div
      class="tab-pane fade {{$done?'':'show active'}}"
      id="{{$au}}-tab"
      role="tabpanel"
    >
        @include('parts.admin.old.promo')
</div>


  </div>
    @php
        $done = true;
    @endphp
  @endforeach
  <!-- Tabs content -->
