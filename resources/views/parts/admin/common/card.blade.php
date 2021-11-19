<div class="border  col-md-3  card text-center m-md-4" >
    <div class="card-body">
    <div class="card-header text-muted">{{$passed}}</div>
    <h5 class="card-title">{{$name}}</h5>
    <p class="card-text ">
       {{$description}}
    </p>

    </div>
    <div class="card-footer text-muted">
        <a class="btn btn-success btn-lg btn-floating" href="{{route($target.".edit",$id)}}">
            <i class="fas fa-pen-nib"></i>
        </a>
        <form class="d-inline" method="post" action="{{route($target.'.destroy',$id)}}">
            @csrf
            @method('delete')
            <button  class="btn btn-danger btn-lg btn-floating" data-mdb-ripple-color="dark">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
</div>
