<table class="table table-bordered  align-middle">
        <?php $count_columns = 0 ?>
        <tr>
            <td rowspan="2"></td>
            @foreach ($sem->modules as $module)
            <th  colspan="{{sizeof($module->devoirs)>0?sizeof($module->devoirs):1}}">
                {{$module->name}}
            </th>
            @endforeach
      </tr>

        <tr>

            @foreach($sem->modules as $module)
            @if(sizeof($module->devoirs)>0)
                @foreach ($module->devoirs as $devoir)
                <td>{{$devoir->name}}</td>
                <?php $count_columns++ ?>
                @endforeach
            @else
                <?php $count_columns++ ?>
                <td> Aucun Devoir</td>
            @endif
            @endforeach
        </tr>
        @if(sizeof($sem->promotion->etudiants)>0)
            @foreach ($sem->promotion->etudiants as $etudiant )
                <th scope="row">{{$etudiant->first_name." ".$etudiant->last_name}}</th>
                @foreach($sem->modules as $module)
                    @if(sizeof($module->devoirs)>0)
                        @foreach ($module->devoirs as $devoir)
                            <?php $evaluation = $etudiant->evaluations->where('devoir_id',$devoir->id)->first(); ?>
                            <td class="border" name="note" id="{{$evaluation->id}}" contenteditable="true">
                                {{$evaluation->note?:0}}
                            </td>
                        @endforeach
                    @else
                        <td>Aucune Note</td>
                    @endif
                @endforeach
            @endforeach
        @else

            <td colspan="{{$count_columns +1 }}">Aucun Etudiant appartient à cette Promotion</td>
        @endif
  </table>
