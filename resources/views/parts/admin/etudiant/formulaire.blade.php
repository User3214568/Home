<div class="col-md-9">
    <p><h2>{{!isset($etudiant)?'Ajouter un Nouveau Etudiant':'Modifier un Etudiant'}}</h2></p>
    @if($errors->any())
        <div class="note note-danger">
            <p>Attention ! On a pas pu enregistrer l'{{$target}}.</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="row container p-3 needs-validation" method="post" action="{{$route}}" novalidate>
        @csrf
        @method('put')
        @foreach( $fields as $field)
                    @if(($field['type'] == 'selection'))
                    <div class="row mt-4">
                        <select class=" border rounded-2   p-2 text-reset" name="{{$field['name']}}" id="input_{{$field['name']}}" required>
                            <option value="{{$field['value']}}" {{(!isset($etudiant))?'selected':''}} disabled>{{$field['label']}}</option>
                            @foreach ($field['items'] as $item)
                                <option value="{{$item->id}}" {{(isset($etudiant) && $etudiant->formation_id == $item->id)?'selected':''}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    @elseif (($field['type'] == 'date'))
                        <div class="row form-outline mt-4 ">
                        <input type="{{$field['type']}}" value="{{isset($etudiant)?$etudiant->born_date:date("Y-m-d")}}" id="input_{{$field['name']}}" name="{{$field['name']}}" class="form-control" required />
                        <label class="form-label"  for="input_{{$field['name']}}">{{$field['label']}}</label>
                        <div class="invalid-feedback mt-1">Veuillez saisir {{$field['label']}} de l'Etudiant.</div>
                    @else
                        <div class="row form-outline mt-4 ">
                        <input type="{{$field['type']}}" id="input_{{$field['name']}}" value="{{$field['value']}}" name="{{$field['name']}}" class="form-control" required />
                        <label class="form-label"  for="input_{{$field['name']}}">{{$field['label']}}</label>
                        <div class="invalid-feedback mt-1">Veuillez saisir {{$field['label']}} de l'Etudiant.</div>
                    @endif
                </div>

        @endforeach
        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success"><h6>{{!isset($etudiant)?'Crée L\'Etudiant':'Modifier L\'Etudiant'}}</h6></button>
        </div>
    </form>
</div>

