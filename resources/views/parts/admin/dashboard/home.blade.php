<script src="/javascript/home.js"></script>
<script>
    var stats = {!! json_encode($stats) !!}
    var fin_stats = {!! json_encode($fin_stats) !!}
    var total_versments =  {!! json_encode($total_versments) !!}
    var total_paiements =  {!! json_encode($total_paiements) !!}
</script>
<div class="row">
    <h2>Acceuil</h2>
    <hr class="dropdown-divider">
</div>
<div class=" mt-1 text-left h5 lead">
</div>
<div class="row">
        <div class="col-md-12 limit">
            <div class=" p-2 bg-primary border  rounded-top text-light  d-flex ">
                <span class="me-2"><i class="fas fa-bell"></i></span>
                <span>Vos Notifications</span>
            </div>

            <div class="p-2 border rounded-bottom">
                @if(sizeof(\Auth::user()->notifications) > 0)
                    @foreach (\Auth::user()->notifications as $notif )
                    @if($notif->pivot->seen == 0)
                    <div class="row justify-content-between">
                        <div class="col-10 d-flex justify-content-start align-items-center ">
                            <img class="me-2 rounded-circle" height="30" src="{{url(route('avatar',['cin'=> isset($user)?$notif->user->cin:'none']))}}" alt="">
                            <span>{{$notif->message}}</span>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <strong>
                                {{ \App\Utilities\Calculation::time_diff($notif->created_at,now())}}
                            </strong>
                        </div>
                    </div>

                    @endif
                    @endforeach
                @else
                    <div class="d-flex justify-content-center align-items-center">
                        <p>Acune Notification à afficher.</p>
                    </div>
                @endif
            </div>
        </div>

</div>
<div class="row mt-4 border-bottom border-top justify-content-around text-dark">
    <div class="col-md-3 border-end  bg-white">
        <div class="col p-3 d-flex justify-content-between border-bottom">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <i class="fas fa-user-graduate fa-2x"></i>
                <span>Etudiants</span>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <p class="h4">{{ $total_etudiants }}</p>
            </div>
        </div>
        <div class="col p-3 d-flex justify-content-between border-bottom">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <i class="fas fa-code-branch fa-2x"></i>
                <span>Formations</span>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <p class="h4">{{ $total_formations }}</p>
            </div>
        </div>
        <div class="col p-3 d-flex justify-content-between border-bottom">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <i class="fas fa-th fa-2x"></i>
                <span>Modules</span>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <p class="h4">{{ $total_modules }}</p>
            </div>
        </div>
        <div class="col p-3 d-flex justify-content-between ">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                <span>Professeurs</span>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <p class="h4">{{ $total_profs }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-9  bg-white"  id="chart1">

    </div>

</div>

<div class="row mt-4">
    <hr class="dropdown-divider">
</div>
<div class="row">
    <div class="col-md-6   border-end  align-items-stretch">
        <div>
            <h5>Revenus</h5>
        </div>
        <div>
            <table class="table">
                <tr><td>-</td><td>-</td><td>-</td></tr>
                <tr>
                    <td>Total Versements</td>
                    <td>{{ $total_versments }}</td>
                    <td>Diirhams</td>
                </tr>
                <tr class="text-success">
                    <td class="h6">Total Revenus</td>
                    <td class="h6">{{ $total_versments }}</td>
                    <td class="h6">Dirhams</td>
                </tr>
            </table>

        </div>

    </div>
    <div class="col-md-6  ">
        <div>
            <h5>Dépenses Totaux</h5>
        </div>
        <div>
            <table class="table ">
                <tr>
                    <td>Paiement des Professeurs</td>
                    <td>{{ $total_paiements }}</td>
                    <td>Dirhams</td>
                </tr>
                <tr>
                    <td>Dépenses Communes</td>
                    <td>{{ $total_deps }}</td>
                    <td>Dirhams</td>
                </tr>
                <tr class="text-danger">
                    <td class="h6">Total Dépenses</td>
                    <td class="h6">{{ $total_deps + $total_paiements }}</td>
                    <td class="h6">Dirhams</td>
                </tr>

            </table>

        </div>

    </div>

</div>
<div class="row">
    <div class="col-lg-6 border-end">
        <div class="h6 text-center">Etat Global des versements des Etudiants</div>
        <div id="chart4"></div>
    </div>
    <div class="col-lg-6">
        <div class="h6 text-center">Etat Global du Paiement des Professeurs</div>
        <div id="chart5"></div>
    </div>

</div>
<div class="row">
    <div class="border-end col-md-6">
        <hr class="dropdown-divider">
        <div class="h6 text-center">Etat du Paiement des Etudiants</div>
        <div id="chart2"></div>
    </div>
    <div class=" col-md-6">
        <hr class="dropdown-divider">
        <div class="h6 text-center">Etat du Paiement des Professeurs</div>
        <div id="chart3"></div>
    </div>
</div>
