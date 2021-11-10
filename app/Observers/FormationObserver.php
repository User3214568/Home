<?php

namespace App\Observers;

use App\Formation;

use App\Utilities\Notificator;


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
        $notif = new Notificator();
        $notif->notificate(' a crée une nouvell formation : ' . $formation->name);
    }

    /**
     * Handle the formation "updated" event.
     *
     * @param  \App\Formation  $formation
     * @return void
     */
    public function updated(Formation $formation)
    {
        $notif = new Notificator();
        $notif->notificate(' a modifié la Formation : ' . $formation->name);
    }

    /**
     * Handle the formation "deleted" event.
     *
     * @param  \App\Formation  $formation
     * @return void
     */
    public function deleted(Formation $formation)
    {
        $notif = new Notificator();
        $notif->notificate(' a supprimé la Formation : ' . $formation->name);
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
