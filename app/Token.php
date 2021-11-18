<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['user_cin','token','expires_at'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function isExpired(){
        $c2 = new Carbon($this->expires_at);
        return $c2->isPast();
    }
}
