<?php

namespace AV_Core\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Affilate extends Model
{
    protected $table = 'affilate';
    // protected $fillable = [];

    public function payment()
    {
        return $this->hasMany('App\Payment');
    }

    static function getAffiliate($id,$attr){
        // $data = Transaction::where('affiliate','!=','')->where('user_id',$id)->first();
        $data = DB::table('transaction')
            ->join('payment', 'payment.id', '=', 'payment.id')
            ->select('transaction.*', 'payment.name as payment')
            ->where('affiliate','!=','')
            ->where('user_id',$id)
            ->where('transaction.status',1)
            ->first();
        if($data)
            return $data->$attr;
        else
            return '-';
    }
}
