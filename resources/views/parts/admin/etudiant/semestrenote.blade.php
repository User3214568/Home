<div class="row">
    <!-- Tabs navs -->
    <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
        @foreach ($promotion->semestres as $key => $semestre)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $key > 0 ? '' : 'active' }}"
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

            @foreach ($promotion->semestres as $key => $sem)

                <div class=" tab-pane fade {{ $key > 0 ? '' : 'show active' }}"
                    id="tabs-{{ $sem->numero . '-' . $promotion->numero }}" role="tabpanel"
                    aria-labelledby="tab-{{ $sem->numero . '-' . $promotion->numero }}">
                    <!-- Tabs navs -->
                    <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="{{ $sem->id }}-modules-all" data-mdb-toggle="tab"
                                href="#tab-{{ $sem->id }}-modules-all" role="tab" aria-controls="ex1-tabs-1"
                                aria-selected="true">{{ isset($result) ? 'Résultat du Semestre' : 'Tous Les Modules' }}</a>
                        </li>
                        @foreach ($sem->modules as $module)
                            <li class="nav-item tab-item" role="presentation">
                                <a class="nav-link " id="{{ $sem->id . '-' . $module->id }}" data-mdb-toggle="tab"
                                    href="#tab-{{ $sem->id . '-' . $module->id }}" role="tab"
                                    aria-controls="ex1-tabs-1" aria-selected="true">{{ $module->name }}</a>
                            </li>

                        @endforeach
                    </ul>
                    <!-- Tabs navs -->
                    <div class="tab-content" id="ex1-content">
                        <div class="tab-pane fade show active" id="tab-{{ $sem->id }}-modules-all" role="tabpanel"
                            aria-labelledby="ex1-tab-1">

                            <!--  TABS FOR ALL MODULES  -->
                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="ord-{{$sem->id}}" data-mdb-toggle="tab" href="#tab-ord-{{$sem->id}}"
                                        role="tab" aria-controls="tab-ord-{{$sem->id}}" aria-selected="true">Session Ordinaire</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="rat-{{$sem->id}}" data-mdb-toggle="tab" href="#tab-rat-{{$sem->id}}"
                                        role="tab" aria-controls="" aria-selected="false">Session Rattrappage</a>
                                </li>

                            </ul>
                            <!-- Tabs navs -->

                            <!-- Tabs content -->
                            <div class="tab-content" id="ex1-content">
                                <div class="tab-pane fade show active" id="tab-ord-{{$sem->id}}" role="tabpanel"
                                    aria-labelledby="ord-{{$sem->id}}">
                                    <div class="table-responsive">
                                        <?php $session = 1; ?>
                                        @if (!isset($result))
                                            @include('parts.admin.etudiant.tablenote')
                                        @else
                                            @include('parts.admin.etudiant.semestre-result')
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-rat-{{$sem->id}}" role="tabpanel" aria-labelledby="ex1-tab-2">
                                    <div class="table-responsive">
                                        <?php $session = 2; ?>
                                        @if (!isset($result))
                                            @include('parts.admin.etudiant.tablenote')
                                        @else
                                            @include('parts.admin.etudiant.semestre-result')
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <!-- Tabs content -->

                        </div>
                        @foreach ($sem->modules as $mymodule)
                            <div class="tab-pane fade" id="tab-{{ $sem->id . '-' . $mymodule->id }}" role="tabpanel"
                                aria-labelledby="ex1-tab-2">
                                    <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="sord-{{ $sem->id . '-' . $mymodule->id }}"
                                                data-mdb-toggle="tab"
                                                href="#tab-sord-{{ $sem->id . '-' . $mymodule->id }}" role="tab"
                                                aria-controls="sord-{{ $sem->id . '-' . $mymodule->id }}"
                                                aria-selected="true">Session Ordinaire</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="srat-{{ $sem->id . '-' . $mymodule->id }}"
                                                data-mdb-toggle="tab"
                                                href="#tab-srat-{{ $sem->id . '-' . $mymodule->id }}" role="tab"
                                                aria-controls="tab-srat-{{ $sem->id . '-' . $mymodule->id }}"
                                                aria-selected="false">Session Rattrappage</a>
                                        </li>

                                    </ul>
                                    <!-- Tabs navs -->

                                    <!-- Tabs content -->
                                    <div class="tab-content" id="ex1-content">
                                        <div class="tab-pane fade show active"
                                            id="tab-sord-{{ $sem->id . '-' . $mymodule->id }}" role="tabpanel"
                                            aria-labelledby="tab-sord-{{ $sem->id . '-' . $mymodule->id }}">
                                            <?php $session = 1; ?>
                                            @if (!isset($result))
                                                @include('parts.admin.etudiant.table-module-note')
                                            @else
                                                @include('parts.admin.etudiant.result-table')
                                            @endif
                                        </div>
                                        <div class="tab-pane fade" id="tab-srat-{{ $sem->id . '-' . $mymodule->id }}"
                                            role="tabpanel"
                                            aria-labelledby="srat-{{ $sem->id . '-' . $mymodule->id }}">
                                            <?php $session = 2; ?>
                                            @if (!isset($result))
                                                @include('parts.admin.etudiant.table-module-note')
                                            @else
                                                @include('parts.admin.etudiant.result-table')
                                            @endif
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

