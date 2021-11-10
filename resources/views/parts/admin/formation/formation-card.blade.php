<div class="border  col-md-3 rounded-0 shadow-5 card text-center m-md-4  text-white" style="{{App\Utilities\Generate::background_color()}}" >
    <div class="card-body d-flex justify-content-between flex-column aling-items-center">
        <div>
            <div class="card-header text-reset">{{App\Utilities\Calculation::time_diff($formation->updated_at)}}</div>
            <h5  class="card-title h4 mt-1 text-wrap">{{$formation->name}}</h5>
            <textarea hidden name="sems">{{$formation}}</textarea>
        </div>
        <button type="button" class="btn btn-primary rounded-0" name="card-formation">Plus d'informations</button>

    </div>
    <div class="card-footer text-muted">

        <a class="btn btn-success btn-lg btn-floating" href="{{route('formation.edit',$formation->id)}}">
            <i class="fas fa-pen-nib"></i>
        </a>
        <form class="d-inline" method="post" action="{{route('formation.destroy',$formation)}}">
            @csrf
            @method('delete')
            <button  class="btn btn-danger btn-lg btn-floating" data-mdb-ripple-color="dark">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
</div>
