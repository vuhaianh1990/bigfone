<?php

namespace AV_Core\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    const ADMIN = 1;
    const CUSTOMER = 2;
    const VIP = 3;
}
