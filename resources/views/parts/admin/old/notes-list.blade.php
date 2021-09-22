<!-- Tabs navs -->
<ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
    <li class="nav-item" role="presentation">
      <a
        class="nav-link active"
        id="list"
        data-mdb-toggle="tab"
        href="#list-tab"
        role="tab"
        aria-selected="true"
        >Liste des Etudiants</a
      >
    </li>
    <li class="nav-item" role="presentation">
      <a
        class="nav-link"
        id="result"
        data-mdb-toggle="tab"
        href="#result-tab"
        role="tab"
        aria-selected="false"
        >Résultats Des Etudiants</a
      >
    </li>

  </ul>
  <!-- Tabs navs -->

  <!-- Tabs content -->
  <div class="tab-content" id="ex2-content">
    <div
      class="tab-pane fade show active"
      id="list-tab"
      role="tabpanel"
      aria-labelledby="ex3-tab-1"
    >
        @include('parts.admin.old.list-etudiants')
    </div>
    <div
      class="tab-pane fade"
      id="result-tab"
      role="tabpanel"
      aria-labelledby="ex3-tab-2"
    >
        @php
            $count = 0;
            $moy = 0;
        @endphp

        @include('parts.admin.old.results')
    </div>

  </div>
  <!-- Tabs content -->
