<div class="row m-2">
    @include('parts.admin.dashboard.sidebar')
    @if(!isset($content))

    @else
    @switch($content)
        @case('formation.create')
            @include('parts.admin.formation.formation')
        @break

        @case('formation.update')
            @include('parts.admin.formation.formation')
        @break

        @case('module.create')
            @include('parts.admin.module.module')
        @break

        @case('module.update')
            @include('parts.admin.formation.formation')
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


        @default

    @endswitch
    @endif
</div>
