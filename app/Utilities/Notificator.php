<?php

namespace App\Utilities;

use App\Notification;
use App\User;
use Illuminate\Support\Facades\Auth;

class Notificator
{
    public function notificate($message)
    {
        $current_user = Auth::user();
        $notif = Notification::create(['message' =>'L\'utilisateur ' . $current_user->first_name .' '. $message]);
        foreach (User::get() as $user) {
            if ($user->cin != $current_user->cin) {
                $notif->users()->attach($user->cin);
            }
        }
    }
}
