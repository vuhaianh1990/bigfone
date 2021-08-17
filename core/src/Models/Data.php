<?php

namespace AV_Core\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = 'data';
    // protected $fillable = [];

    public function dataUser()
    {
        return $this->hasMany('App\DataUser');
    }
}
