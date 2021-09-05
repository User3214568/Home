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

        @case('etudiant.result')
        @include('parts.admin.etudiant.resultat')
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


        @case('finance.add.tranche')
        @include('parts.admin.finance.addtranche')
        @break

        @case('finance.tranche.edit')
        @include('parts.admin.finance.edit-tranche')
        @break

        @case('finance.add.payement')
        @include('parts.admin.finance.profpay')
        @break

        @case('finance.payement.update')
        @include('parts.admin.finance.profpay')
        @break

        @case('finance.payement.consultants')
        @include('parts.admin.finance.consultantspay')
        @break

        @case('finance.versemnt.list')
        @include('parts.admin.finance.list-vers')
        @break

        @case('professeur.create')
        @include('parts.admin.Professeur.add-prof')
        @break
        @case('professeur.update')
        @include('parts.admin.Professeur.edit-prof')
        @break
        @case('list-prof')
        @include('parts.admin.Professeur.list-prof')
        @break


        @case('etudiant.imported')
        @include('parts.admin.etudiant.imported-list')
        @break

        @default

        @endswitch
        @endif

    </div>
</div>
