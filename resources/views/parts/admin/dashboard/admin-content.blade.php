<div class="row m-2">
    @include('parts.admin.dashboard.sidebar')
    <div class="col-md-9" id="admin-content">

        @if(!isset($content))

        @else
        @switch($content)
        @case('formation.create')
        @include('parts.admin.formation.formation')
        @break

        @case('formation.update')
        @include('parts.admin.formation.formation')
        @break
        @case('formation.index')
        @include('parts.admin.formation.index')
        @break

        @case('module.create')
            @include('parts.admin.module.module')
        @break

        @case('module.update')
        @include('parts.admin.module.module')
        @break

        @case('module.index')
        @include('parts.admin.module.index')
        @break

        @case('etudiant.create')
        @include('parts.admin.etudiant.etudiant')
        @break

        @case('etudiant.update')
        @include('parts.admin.etudiant.etudiant')
        @break

        @case('etudiant.index')
        @include('parts.admin.etudiant.list')
        @break

        @case('etudiant.evaluation')
        @include('parts.admin.etudiant.evaluation')
        @break

        @case('etudiant.note.module')
        @include('parts.admin.etudiant.note-module')
        @break

        @case('user.create')
        @include('parts.admin.user.user')
        @break

        @case('user.update')
        @include('parts.admin.user.user')
        @break

        @case('user.index')
        @include('parts.admin.user.index')
        @break

        @default

        @endswitch
        @endif

    </div>
</div>
