<?php

namespace AV_Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AV_Core\Http\Controllers\Controller;
use Auth;
use AV_Core\Models\DataUser;
use Carbon\Carbon;
use AV_Core\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // Get User
        $user           = Auth::user();
        $dataUserCount  = DataUser::where('user_id', $user->id)->get();

        $called     = 0;
        $wrongPhone = 0;
        $cotter     = 0;
        if ($dataUserCount->count() > 0) {
            foreach($dataUserCount as $item) {
                if ($item->called == 1) {
                    $called += 1;
                }

                if ($item->wrongPhone == 1) {
                    $wrongPhone += 1;
                }

                if ($item->cotter == 1) {
                    $cotter += 1;
                }
            }
        }

        if($user->usertype == '1'){
            $now     = Carbon::now();
            if ($user->expired < $now)  {
                $expired = [
                    'name' => 'Thời gian sử dụng',
                    'value' => 'Thời gian sử dụng đã hết',
                    'vip' => 0
                ];
            } else {
                $expired = [
                    'name' => 'Thời gian sử dụng',
                    'value' => $user->expired,
                    'vip' => 1
                ];
            }
        }else{
            if ($user->profit >= $user->credit) {
                $expired = [
                    'name'  => 'Số lần sử dụng còn lại:',
                    'value' => 'Số lần sử dụng đã hết',
                    'vip' => 0
                ];
            } else {
                $expired = [
                    'name'  => 'Số lần sử dụng còn lại:',
                    'value' => ($user->credit - $user->profit),
                    'vip' => 1
                ];
            }
        }

        return admin_view('home', [
            'user'          => $user,
            'dataUser'      => $dataUserCount->count(),
            'called'        => $called,
            'wrongPhone'    => $wrongPhone,
            'cotter'        => $cotter,
            'expired'       => $expired
        ]);
    }

    public function getUser(){
        $data = User::where('usertype','0')->orderBy('created_at','desc')->paginate(10);
        return admin_view('list-user',compact('data'));
    }

    public function switchCallUser(Request $request){
        if ($request->value == '0'){
            $value = 1;
        }else if($request->value == '1'){
            $value = 0;
        }else{
            $value = $request->value;
        }
        $dataUser = User::where('id', $request->id)->update([
            $request->name => $value
        ]);
    }
}
