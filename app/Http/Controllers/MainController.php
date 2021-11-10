<?php

namespace App\Http\Controllers;

use App\Depenses;
use App\Formation;
use App\Teacher;
use App\Token;
use App\User;
use App\Utilities\MailSender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function index(){

        return view('index');
    }
    public function login(){
        $r = $this->redirecIfLogin();
        if($r) return $r;
        return view('login');
    }
    public function restorePassword(){
        $r = $this->redirecIfLogin();
        if($r) return $r;
        return view('pass-forg');
    }
    public function redirecIfLogin(){
        if(Auth::check()){
            return redirect(route('admin'));
        }
        return null;
    }
    public function sendRestorePassword(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users,email|max:100'
        ]);
        $token =  Str::random(32);
        $user = User::where('email',$request->email)->first();
        if($user){
            $expires_at = Carbon::now()->addMinutes(30);
            Token::create(['token'=>bcrypt($token),'expires_at'=> $expires_at,'user_cin'=>$user->cin]);
            $sender = new MailSender();
            $sender->sendMail($request->email,"Password Reset",$user,url("/login/".$token));
        }
        return redirect('/restore-password');
    }
    public function loginWithToken($token){
        $tokens = Token::get();
        $token_user = null;
        foreach($tokens as $t){
            if(Hash::check($token,$t->token)){
                $token_user = $t;
                break;
            }
        }
        if($token_user){
            $user = $token_user->user;
            if(!$token_user->isExpired()){
                Auth::login($user);
                $token_user->delete();
            }else{
                dd("expired");die();
            }
        }
        return redirect(route('admin'));
    }
    public function admin(){
        $content = "admin.home";

        $total_etudiants  = 0 ;
        $total_formations  = 0 ;
        $total_modules = 0 ;
        $total_profs = sizeof(Teacher::get());
        $total_paiements = 0;
        $total_versments = 0;
        $total_avers = 0;
        $total_deps = 0;
        $stats = [];
        $fin_stats = [];

        foreach(Depenses::get() as $dep){
            $total_deps += $dep->somme;
        }
        foreach (Formation::get() as $formation) {
            $size_etudiant = sizeof($formation->etudiants);
            $size_profs = sizeof($formation->professeurs);

            $size_modules = $formation->getEffectif();
            $paiements = $formation->getPaiements();
            $f_total_paiements = $formation->totalPaiements();
            $total_paiements += $f_total_paiements;
            $stats[$formation->name] = [
                'etudiants'=>$size_etudiant,
                'modules' => $size_modules,
                'profs'=> $size_profs
            ];
            $f_total_versements = $formation->getVersement();
            $total_versments += $f_total_versements;
            $fin_stats[$formation->name] = [
                'total_vers'=>$size_etudiant*$formation->prix,
                'vers'=>$f_total_versements,
                'total_paiements' => $f_total_paiements,
                'paiements'=> $paiements
            ];
            $total_modules += $size_modules;
            $total_etudiants += $size_etudiant;
            $total_formations++;
        }
        return view('admin',compact(['content','total_deps','fin_stats','total_versments','total_paiements','total_profs','total_modules','stats','total_formations','total_etudiants']));
    }

}
