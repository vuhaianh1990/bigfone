<?php

namespace AV_Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AV_Core\Http\Controllers\Controller;
use Auth;
use AV_Core\Models\User;
use Yajra\Datatables\Datatables;
use DB;
use AV_Core\Models\Affilate;
use Carbon\Carbon;


class ManagementAffilateController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $link = 'https://facefone.vn/?ffref='.$id;
        $data = User::select([
            'id',
            'created_at',
            'name',
            'email',
            'phone',
        ])->where('seller', $id)->orderBy('created_at', 'desc')->get();
        // $p = Affilate::getAffiliate(100,'payment_id');
        // return $p;
        return admin_view('affilate',compact('link','data'));
    }

    public function getAffilate(Request $request){
        $user = Auth::user();
        $data = User::select([
            'id',
            'created_at',
            'name',
            'email',
            'phone',
        ])->where('seller', $user->id)->orderBy('created_at', 'desc')->get();

        return admin_view('affiliate',compact('data'));
        // $data = DB::table('users')
        //     ->join('transaction', 'users.id', '=', 'transaction.user_id')
        //     ->join('payment', 'payment.id', '=', 'transaction.payment_id')
        //     ->select('transaction.*', 'users.name as name_user', 'payment.name')
        //     ->where('users.seller',$user->id)
        //     ->orderBy('users.created_at','desc')
        //     ->get();
        // echo "<pre>";
        // var_dump($data);
        // return Datatables::of($data)
        //         ->filter(function($query) use ($request) {
        //             $date_start = $request->date_start;
        //             $date_end   = $request->date_end;

        //             if ($date_end != '') {
        //                 if ($date_start != '') {
        //                     $query->whereDate('created_at', '<=', $date_end)
        //                         ->whereDate('created_at', '>=', $date_start);
        //                 } else {
        //                     $query->whereDate('created_at', '<=', $date_end);
        //                 }
        //             } else {
        //                 if ($date_start != '') {
        //                     $query->whereDate('created_at', $date_start);
        //                 }
        //             }
        //         })
        //         ->make(true);
    }
}
