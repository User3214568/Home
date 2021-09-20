<div class="row">
    <!-- Tabs navs -->
    <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
        @php $done = false; @endphp
        @foreach ($promotion->semestres->sortBy('numero') as $key => $semestre)
            <li  name="triggers-semestre" class="nav-item" role="presentation">
                <a class="nav-link {{ $done ? ' ' : 'active' }}" @php $done = true; @endphp
                    id="tab-{{ $semestre->numero . '-' . $promotion->numero }}" data-mdb-toggle="tab"
                    href="#tabs-{{ $semestre->numero . '-' . $promotion->numero }}" role="tab"
                    aria-controls="tabs-{{ $semestre->numero . '-' . $promotion->numero }}"
                    aria-selected="true">{{ 'Semestre ' . $semestre->numero }}</a>
            </li>
        @endforeach
    </ul>
    <!-- Tabs navs -->

    <div class="tab-content" id="content">
        @if (sizeof($promotion->semestres) > 0)
        @php $done = false; $render = true; @endphp
            @foreach ($promotion->semestres->sortBy('numero') as $key => $sem)

                <div class=" tab-pane fade {{ ( $done ? ' ' : 'show active') }}"
                    id="tabs-{{ $sem->numero . '-' . $promotion->numero }}" role="tabpanel"
                    aria-labelledby="tab-{{ $sem->numero . '-' . $promotion->numero }}">
                    <!-- Tabs navs -->
                    @php $done = true; @endphp
                    <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                        <li  name="triggers" class="nav-item" role="presentation">
                            <a class="nav-link active" id="{{ $sem->id . '-' . $promotion->name }}-modules-all"
                                data-mdb-toggle="tab" href="#tab-{{ $sem->id . '-' . $promotion->name }}-modules-all"
                                role="tab" aria-controls="ex1-tabs-1"
                                aria-selected="true">{{ isset($result) ? 'Résultat du Semestre' : 'Tous Les Modules' }}</a>
                        </li>
                        @foreach ($sem->modules as $module)
                            <li  name="triggers" class="nav-item tab-item" role="presentation">
                                <a class="nav-link "
                                    id="{{ $sem->id . '-' . $promotion->name . '-' . $module->id }}"
                                    data-mdb-toggle="tab"
                                    href="#tab-{{ $sem->id . '-' . $promotion->name . '-' . $module->id }}" role="tab"
                                    aria-controls="ex1-tabs-1" aria-selected="true">{{ $module->name }}</a>
                            </li>

                        @endforeach
                    </ul>
                    <!-- Tabs navs -->
                    <div class="tab-content" id="ex1-content">
                        <div class="tab-pane fade show active"
                            id="tab-{{ $sem->id . '-' . $promotion->name }}-modules-all" role="tabpanel"
                            aria-labelledby="ex1-tab-1">

                            <!--  TABS FOR ALL MODULES  -->
                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                <li  name="triggers-session" class="nav-item" role="presentation">
                                    <a class="nav-link active" id="ord-{{ $sem->id . '-' . $promotion->name }}"
                                        data-mdb-toggle="tab" href="#tab-ord-{{ $sem->id . '-' . $promotion->name }}"
                                        role="tab" aria-controls="tab-ord-{{ $sem->id . '-' . $promotion->name }}"
                                        aria-selected="true">Session
                                        Ordinaire</a>
                                </li>
                                <li  name="triggers-session" class="nav-item" role="presentation">
                                    <a class="nav-link" id="rat-{{ $sem->id . '-' . $promotion->name }}"
                                        data-mdb-toggle="tab" href="#tab-rat-{{ $sem->id . '-' . $promotion->name }}"
                                        role="tab" aria-controls="" aria-selected="false">Session Rattrappage</a>
                                </li>

                            </ul>
                            <!-- Tabs navs -->

                            <!-- Tabs content -->
                            <div class="tab-content" id="ex1-content">
                                <div name="notes" semestre="{{$sem->id}}" session="1" result="{{isset($result)?'true':'false'}}" promotion="{{$promotion->id}}" class="tab-pane fade show active"
                                    id="tab-ord-{{ $sem->id . '-' . $promotion->name }}" role="tabpanel"
                                    aria-labelledby="ord-{{ $sem->id . '-' . $promotion->name }}">
                                    <?php $session = 1; ?>
                                    @if (!isset($result))
                                        <div class="row justify-content-end">
                                            <button onclick="save(this)" name="savenote"
                                                title="Enregistrer les modifications"
                                                class="me-2 btn btn-info btn-floating">
                                                <i class="fas fa-save"></i>
                                            </button>
                                            <a title="Commiter Les Notes du Session Ordinaire" name="commitOrd"
                                                href="{{ route('module.commit.notes', ['promotion_id' => $promotion->id, 'sem_id' => $sem->id, 'module_id' => 0]) }}"
                                                class="btn btn-info btn-floating  ms-2">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </div>
                                        <div class="table-responsive mt-2">
                                            @if($render)
                                                @include('parts.admin.etudiant.tablenote')
                                            @endif
                                        </div>
                                    @else

                                        <div class="table-responsive mt-2">
                                            @if($render)
                                                @include('parts.admin.etudiant.semestre-result')
                                            @endif
                                        </div>
                                    @endif
                                    @php $render = false;  @endphp
                                </div>
                                <div name="notes" semestre="{{$sem->id}}" session="2" result="{{isset($result)?'true':'false'}}" promotion="{{$promotion->id}}" class="tab-pane fade" id="tab-rat-{{ $sem->id . '-' . $promotion->name }}"
                                    role="tabpanel" aria-labelledby="ex1-tab-2">
                                    <?php $session = 2; ?>
                                    @if (!isset($result))
                                        <div class="row justify-content-end">
                                            <button onclick="save(this)" name="savenote"
                                                title="Enregistrer les modifications"
                                                class="me-2 btn btn-info btn-floating">
                                                <i class="fas fa-save"></i>
                                            </button>

                                        </div>
                                        <div class="table-responsive mt-2">
                                            <!-- ('parts.admin.etudiant.tablenote') -->
                                        </div>
                                    @else
                                        <div class="table-responsive mt-2">
                                            <!--('parts.admin.etudiant.semestre-result')-->
                                        </div>
                                    @endif

                                </div>

                            </div>
                            <!-- Tabs content -->

                        </div>
                        @php $showModule = false; @endphp
                        @foreach ($sem->modules as $mymodule)
                            <div class="tab-pane fade"
                                id="tab-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}" role="tabpanel"
                                aria-labelledby="ex1-tab-2">
                                <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                    <li  name="triggers-session-module" class="nav-item" role="presentation">
                                        <a class="nav-link active"
                                            id="sord-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}"
                                            data-mdb-toggle="tab"
                                            href="#tab-sord-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}"
                                            role="tab"
                                            aria-controls="sord-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}"
                                            aria-selected="true">Session Ordinaire</a>
                                    </li>
                                    <li  name="triggers-session-module" class="nav-item" role="presentation">
                                        <a class="nav-link"
                                            id="srat-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}"
                                            data-mdb-toggle="tab"
                                            href="#tab-srat-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}"
                                            role="tab"
                                            aria-controls="tab-srat-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}"
                                            aria-selected="false">Session Rattrappage</a>
                                    </li>

                                </ul>
                                <!-- Tabs navs -->

                                <!-- Tabs content -->
                                <div class="tab-content" id="ex1-content">
                                    <div name="notes-module" session="1" module="{{$mymodule->id}}" semestre="{{$sem->id}}" result="{{isset($result)?'true':'false'}}" promotion="{{$promotion->id}}" class="tab-pane fade show active"
                                        id="tab-sord-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}"
                                        role="tabpanel"
                                        aria-labelledby="tab-sord-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}">
                                        <div class="row justify-content-end">
                                            @if (!isset($result))
                                                <form class="row justify-content-end"
                                                    action="{{ route('etudiant.notes.import', ['sem_id' => $sem->id, 'module_id' => $mymodule->id, 'session' => 1]) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <button type="button" name="importModule"
                                                        title="Importer Les Notes du Module"
                                                        class="btn btn-success btn-floating ">
                                                        <i class="fas fa-upload"></i>

                                                    </button>
                                                    <input name="file" type="file" hidden>
                                                    <a title="Exporter Les Notes du Module" name="exportModule"
                                                        href="{{ route('etudiant.notes.module.export', ['sem_id' => $sem->id, 'module_id' => $mymodule->id, 'session' => 1, 'type' => 'false']) }}"
                                                        class="btn btn-success btn-floating ms-2">
                                                        <i class="fas fa-download"></i>

                                                    </a>
                                                    <a title="Commiter Les Notes du Session Ordinaire" name="commitOrd"
                                                        href="{{ route('module.commit.notes', ['promotion_id' => $promotion->id, 'sem_id' => $sem->id, 'module_id' => $mymodule->id]) }}"
                                                        class="btn btn-info btn-floating  ms-2">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <button type="button" onclick="save(this)" name="savenote"
                                                        title="Enregistrer les modifications"
                                                        class="btn btn-info btn-floating  ms-2">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                    <button type="submit" id="submit" hidden></button>

                                                </form>
                                            @else
                                            <div class="row justify-content-end ">
                                                <a title="Exporter les Résultat" href="{{route('export.resultat.modules',['promotion_id'=>$promotion->id,'module_id'=>$mymodule->id,"session"=>1])}}" class="btn btn-danger btn-floating">
                                                    <i class="fas fa-file-export"></i>
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="table-responsive mt-2">
                                            <?php $session = 1; ?>
                                            @if (!isset($result))
                                                @if($showModule)
                                                    @include('parts.admin.etudiant.table-module-note')
                                                @endif
                                            @else
                                                @if($showModule)
                                                    @include('parts.admin.etudiant.result-table')
                                                @endif
                                            @endif
                                            @php $showModule = false; @endphp
                                        </div>
                                    </div>
                                    <div name="notes-module" session="2"  module="{{$mymodule->id}}" semestre="{{$sem->id}}" result="{{isset($result)?'true':'false'}}" promotion="{{$promotion->id}}" class=" tab-pane fade"
                                        id="tab-srat-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}"
                                        role="tabpanel"
                                        aria-labelledby="srat-{{ $sem->id . '-' . $promotion->name . '-' . $mymodule->id }}">
                                        @if (!isset($result))
                                            <form class="row justify-content-end"
                                                action="{{ route('etudiant.notes.import', ['sem_id' => $sem->id, 'module_id' => $mymodule->id, 'session' => 2]) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <button type="button" name="importModule"
                                                    title="Importer Les Notes du Module"
                                                    class="btn btn-success btn-floating">
                                                    <i class="fas fa-upload"></i>
                                                </button>
                                                <input name="file" type="file" hidden>
                                                <a title="Exporter Les Notes du Module" name="exportModule"
                                                    href="{{ route('etudiant.notes.module.export', ['sem_id' => $sem->id, 'module_id' => $mymodule->id, 'session' => 2, 'type' => 'false']) }}"
                                                    class="btn btn-danger btn-floating ms-2">
                                                    <i class="fas fa-download fa-1x"></i>
                                                </a>
                                                <button type="button" name="savenote"
                                                    title="Enregistrer les modifications"
                                                    class="btn btn-info btn-floating  ms-2">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                                <button type="submit" id="submit" hidden></button>
                                            </form>
                                        @else
                                        <div class="row justify-content-end ">
                                            <a title="Exporter les Résultat" href="{{route('export.resultat.modules',['promotion_id'=>$promotion->id,'module_id'=>$mymodule->id,"session"=>2])}}" class="btn btn-danger btn-floating">
                                                <i class="fas fa-file-export"></i>
                                            </a>
                                        </div>
                                        @endif
                                        <div class="table-responsive mt-2">
                                            <?php $session = 2; ?>
                                            @if (!isset($result))
                                            <!-- ('parts.admin.etudiant.table-module-note')-->
                                            @else
                                              <!--  ('parts.admin.etudiant.result-table')-->
                                            @endif
                                        </div>
                                    </div>

                                </div>

                            </div>

                        @endforeach
                    </div>
                    <!-- Tabs content -->


                </div>

            @endforeach
        @else
            <div class="row justify-content-center">Aucune donnée à afficher</div>
        @endif

    </div>

</div>
