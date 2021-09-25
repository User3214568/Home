<!-- Tabs navs -->
<ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
    <li class="nav-item" role="presentation">
      <a
        class="nav-link active"
        id="sord"
        data-mdb-toggle="tab"
        href="#tab--mod-{{ str_replace(' ','',$formation).str_replace(' ','',$module) }}-sord"
        role="tab"
        aria-selected="true"
        >Session Ordinaire</a
      >
    </li>
    <li class="nav-item" role="presentation">
        <a
        class="nav-link "
        id="srat"
        data-mdb-toggle="tab"
        href="#tab--mod-{{ str_replace(' ','',$formation).str_replace(' ','',$module) }}-srat"
        role="tab"
        aria-selected="true"
        >Session Rattrappage</a
      >
    </li>

  </ul>
  <!-- Tabs navs -->

  <!-- Tabs content -->
  <div class="tab-content" id="ex1-content">
    <div
      class="tab-pane fade show active"
      id="tab--mod-{{ str_replace(' ','',$formation).str_replace(' ','',$module) }}-sord"
      role="tabpanel"
    >
        @php
            $session = 1;
        @endphp
      @include('parts.enseignant.notes.notes-table')
    </div>
    <div
      class="tab-pane fade"
      id="tab--mod-{{ str_replace(' ','',$formation).str_replace(' ','',$module) }}-srat"
      role="tabpanel"
    >
        @php
            $session = 2;
        @endphp
        @include('parts.enseignant.notes.notes-table')

    </div>
  </div>
  <!-- Tabs content -->
