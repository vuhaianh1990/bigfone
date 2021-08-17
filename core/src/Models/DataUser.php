<?php

namespace AV_Core\Models;

use Illuminate\Database\Eloquent\Model;

class DataUser extends Model
{
    protected $table = 'data_user';

    protected $fillable = [
        'user_id',
        'data_id',
        'name',
        'avatar',
        'phone',
        'email',
        'gender',
        'location',
        'work',
        'note',
        'called',
        'wrong_phone',
        'source',
        'link'
    ];

    public function data()
    {
        return $this->belongsTo('App\Data');
    }
}
