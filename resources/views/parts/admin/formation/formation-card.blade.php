<div class="border  col-md-3  card text-center m-4">
    <div class="card-body">
    <div class="card-header text-muted">{{App\Utilities\Calculation::time_diff($formation->updated_at)}}</div>
    <h5 class="card-title">{{$formation->name}}</h5>
    <p class=" card-text">
       {{$formation->description}}
    </p>
    <hr class="dropdown-divider">
    <div class="card-text row">
        @foreach ($formation->semestres as $sem)
            @foreach ($sem->modules as  $module)
                <span class="col m-1 card-formation-module">{{$module->name}}</span>
            @endforeach
        @endforeach
    </div>
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
