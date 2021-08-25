
    <p><h2>{{(!isset($etudiant) && !isset($user) && !isset($module))?"Ajouter un Nouveau $target":"Modifier $target"}}</h2></p>
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
        @if(isset($etudiant) || isset($user) || isset($module))
            @method('put')
        @endisset
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
                            <div class="invalid-feedback mt-5">Veuillez saisir {{$field['label']}} .</div>
                    @elseif(($field['type'] == 'textarea'))
                            <div class="row mt-4 form-outline">
                                <textarea  type="{{$field['type']}}" id="input_{{$field['name']}}" name="{{$field['name']}}" class="form-control" rows="8"  required>{{$field['value']}}</textarea>
                                <label class="form-label" for="input_{{$field['name']}}">{{$field['label']}}</label>
                                <div class="invalid-feedback mt-5">Veuillez saisir {{$field['label']}} .</div>
                    @else
                        <div class="row form-outline mt-4 ">
                        <input type="{{$field['type']}}" id="input_{{$field['name']}}" value="{{$field['value']}}" name="{{$field['name']}}" class="form-control" required />
                        <label class="form-label"  for="input_{{$field['name']}}">{{$field['label']}}</label>
                        <div class="invalid-feedback mt-5">Veuillez saisir {{$field['label']}} .</div>
                    @endif
                </div>

        @endforeach
        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success"><h6>{{(!isset($etudiant) && !isset($user) && !isset($module))?"Crée L' $target":"Modifier L' $target"}}</h6></button>
        </div>
    </form>

