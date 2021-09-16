<?php

namespace App\Observers;

use App\Formation;
use App\Notification;
use App\User;
use Illuminate\Support\Facades\Auth;

class FormationObserver
{
    /**
     * Handle the formation "created" event.
     *
     * @param  \App\Formation  $formation
     * @return void
     */
    public function created(Formation $formation)
    {
        $current_user = Auth::user();
        $notif = Notification::create(['message'=>'L\'utilisateur '.$current_user->first_name .' a crée une nouvell formation : '.$formation->name]);
        foreach (User::get() as $user) {
           if($user->cin != $current_user->cin){
               $notif->users()->attach($user->cin);
           }
        }
    }

    /**
     * Handle the formation "updated" event.
     *
     * @param  \App\Formation  $formation
     * @return void
     */
    public function updated(Formation $formation)
    {
        //
    }

    /**
     * Handle the formation "deleted" event.
     *
     * @param  \App\Formation  $formation
     * @return void
     */
    public function deleted(Formation $formation)
    {
        //
    }

    /**
     * Handle the formation "restored" event.
     *
     * @param  \App\Formation  $formation
     * @return void
     */
    public function restored(Formation $formation)
    {
        //
    }

    /**
     * Handle the formation "force deleted" event.
     *
     * @param  \App\Formation  $formation
     * @return void
     */
    public function forceDeleted(Formation $formation)
    {
        //
    }
}
