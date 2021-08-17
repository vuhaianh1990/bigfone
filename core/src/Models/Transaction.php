<?php

namespace AV_Core\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'payment_id',
        'status',
        'price',
        'affiliate'
    ];
    public function Payment(){
        return $this->belongsTo('App\Payment');
    }

    public function User(){
        return $this->belongsTo('App\user');
    }

}
