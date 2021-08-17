<?php

namespace AV_Core\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'uid', 'avatar', 'location', 'work', 'gender',
        'token', 'loginip', 'authcode', 'lastlogindate', 'credit', 'profit',
        'packtype', 'usertype', 'status', 'utm_source', 'utm_medium', 'utm_campaign',
        'utm_term', 'seller', 'role_id', 'expired'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    static function isAdmin(){
        if(Auth::user()->role_id == 1)
            return TRUE;
        elseif(Auth::user()->role_id == 2){
            return FALSE;
        }
    }
}
