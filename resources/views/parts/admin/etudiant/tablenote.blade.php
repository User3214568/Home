<table class="table">
    <thead class="table-dark">
      <tr>
        <th scope="col">#</th>
        @foreach ($semestre->modules as $module)
            <th scope="col">{{$module->name}}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach ($sem->promotion->etudiants as $etudiant)
        <tr>
            <td>
                {{$promo->nom}}
                {{$etudiant->first_name}}
            </td>
        </tr>
      @endforeach
    </tbody>
  </table>
