<div class="container p-3">
    <p class="mt-5"><h1>Gestion pédagogique et Financière des Formations</h1></p>
    <div class="row  justify-content-center">
        <div class="col-lg-6  d-flex justify-content-center align-items-center flex-column">
            <p><span class="index-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores consequuntur voluptatibus recusandae expedita asperiores sunt iste labore dolores, nam eos, ipsum omnis accusantium magnam, soluta minus harum itaque quasi praesentium.</span></p>
            @if(Auth::check())
                <a class="btn btn-link mt-3 btn-wrap" href="/admin"><h6>
                        Acceder à mon Espace Admin
                </h6></a>
                @else
                    <a class="btn btn-link mt-3 btn-wrap" href="/login"><h6>
                        Se Connecter
                    </h6></a>
                @endif
        </div>
        <div class="col-lg-6 justify-content-center align-items-center">
            <img src="/images/index.png" class="img-fit" alt="">
        </div>
    </div>
    <hr class="dropdown-dvider">
    <div class="row mt-4" id="func">
        <p><h5>Nos Fonctionnalitées</h5></p>
        <div class=" text-reset p-4">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rerum temporibus saepe veniam nesciunt assumenda nobis et obcaecati porro alias tempore, molestias neque nulla quo ullam officia amet minima suscipit repellendus.
        </div>
    </div>
    <hr class="dropdown-dvider">
    <div class="row mt-4" id="about">
        <p><h5>A propos de Nous</h5></p>
        <div class=" text-reset p-4">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rerum temporibus saepe veniam nesciunt assumenda nobis et obcaecati porro alias tempore, molestias neque nulla quo ullam officia amet minima suscipit repellendus.
        </div>
    </div>
</div>

