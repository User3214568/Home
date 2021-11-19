<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Session;

trait AuthTrait{
    public function actingUser()
    {
        $user = User::where('type',0)->first();
        if(!$user) $user = factory(User::class)->make(['type'=>0]);
        Session::start();
        $this->actingAs($user);
    }
}
