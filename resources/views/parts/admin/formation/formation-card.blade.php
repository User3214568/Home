<div class="border  col-3  card text-center m-4">
    <div class="card-body">
    <div class="card-header text-muted">2 days ago</div>
    <h5 class="card-title">{{$formation->name}}</h5>
    <p class="card-text text-truncate">
       {{$formation->description}}
    </p>

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
