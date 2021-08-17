<?php

namespace AV_Core\Http\Controllers\Superadmin;

use Illuminate\Http\Request;
use AV_Core\Http\Controllers\Controller;
use Illuminate\Support\Str;
use AV_Core\Models\Payment;
use Auth;
use AV_Core\Models\Transaction;
use Session;
use DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use AV_Core\Models\User;

class TransactionController extends Controller
{
    public function index()
    {
        return superadmin_view('transaction');
    }

    public function getList(Request $request){
        $user = Auth::user();
        $data = DB::table('transaction')
            ->join('users', 'users.id', '=', 'transaction.user_id')
            ->join('payment', 'payment.id', '=', 'transaction.payment_id')
            ->select('transaction.*', 'users.phone', 'payment.name as name_payment')
            ->orderBy('transaction.created_at','DESC')
            ->get();
        return Datatables::of($data)
                ->filter(function($query) use ($request) {
                    $date_start = $request->date_start;
                    $date_end   = $request->date_end;

                    if ($date_end != '') {
                        if ($date_start != '') {
                            $query->whereDate('created_at', '<=', $date_end)
                                ->whereDate('created_at', '>=', $date_start);
                        } else {
                            $query->whereDate('created_at', '<=', $date_end);
                        }
                    } else {
                        if ($date_start != '') {
                            $query->whereDate('created_at', $date_start);
                        }
                    }
                })
                ->make(true);
    }

    public function acceptTransaction(Request $request){
        $now = Carbon::now();
        $id = $request->id;
        Transaction::where('id',$id)->update([
            'status' => 1
        ]);
        $transaction = Transaction::find($id);
        $payment = Payment::find($transaction->payment_id);
        if($payment->payment_type == 0){
            $date = $now->addMonth();
        }else{
            $date = $now->addYear();
        }

        $result = User::where('id',$transaction->user_id)->update([
            'usertype' => 1,
            'expired'  => $date,
        ]);
        if($result){
            return response()->json([
                'status' => 200,
                'msg'    => 'Success'
            ]);
        }

    }
}
