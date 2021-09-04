<script type="module" src="/javascript/versement.js"></script>
<div class="row">
    <h2>@yield("title-list")</h2>
</div>
<div class="row">
    <hr class="dropdown-divider">
</div>
<div class="row mt-3 justify-content-center">
    <div class="col-6">
        <select id="formation-select" class="text-reset border col-md-3 p-2 w-100">
            <option value="0">Tous Les Formation</option>
            @foreach ($formations as $form)
                <option value="{{$form->id }}">{{$form->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row mt-4 justify-content-around">
    <div class="col-sm-4 form-outline">
        <i class="fas fa-search trailing"></i>
        <input type="text" id="search" class="form-control form-icon-trailing" />
        <label class="form-label" for="search">Chercher </label>
    </div>

    <form method="post" id="importForm" action="@yield("route-import")" class="col-sm-7 d-flex justify-content-end "
        enctype="multipart/form-data">
        @csrf
        <a href="@yield('route-create')"
            title="" class="col-1 btn btn-primary btn-floating me-2">
            <i class="fas fa-plus"></i>
        </a>
        <input id="fileInput" type="file" name="file" hidden>
        <button type="button" id="importVersement" title=""
            class="col-1 btn btn-success btn-floating" hidden>
            <i class="fas fa-upload"></i>
        </button>
        <button type="submit" id="submit-import" hidden></button>
        <a href="@yield("route-export")'" id="export"
            title="" class="col-1 btn btn-danger btn-floating ms-2">
            <i class="fas fa-download"></i>
        </a>
        <a href="@yield("route-export-empty")" id="exportEmpty" hidden
            title="" class="col-1 btn btn-dark btn-floating ms-2">
            <i class="fas fa-download"></i>
        </a>
    </form>
</div>
<div class="table-responsive mt-5">
    <table class="table table-bordered table-sm align-middle text-center text-nowrap " id="conten-table">
        @yield('table')
    </table>
</div>
