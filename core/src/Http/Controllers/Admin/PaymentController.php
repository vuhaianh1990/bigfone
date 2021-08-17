<?php

namespace AV_Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AV_Core\Http\Controllers\Controller;
use Illuminate\Support\Str;
use AV_Core\Models\Payment;
use Auth;
use AV_Core\Models\Transaction;
use Session;
use DB;

class PaymentController extends Controller
{
    public function index()
    {
        $data = Payment::all();
        return admin_view('payment',compact('data'));
    }

    public function order(Request $request){
        $transactionId = 'FF-'.Str::upper(Str::random(8));
        $id = Auth::user()->id;
        $paymentId = $request->id;
        $data = Payment::find($paymentId);
        $transaction = Transaction::where('user_id',$id)->get();
        if(Auth::user()->seller != NULL && count($transaction) == 0 ){
            $price = str_replace(',', '', $data->price);
            $affiliate = (intval($price) * 30) / 100;
            $result = Transaction::create([
                'id' => $transactionId,
                'user_id' => $id,
                'payment_id' => $paymentId,
                'price' => $data->price,
                'status' => 0,
                'affiliate' => $affiliate
            ]);

        }else{
            $result = Transaction::create([
                'id' => $transactionId,
                'user_id' => $id,
                'payment_id' => $paymentId,
                'price' => $data->price,
                'status' => 0,
            ]);
        }

        if($result)
            return 'Success';
        else
            return 'Fail';
    }

    public function listTransaction(){
        $id = Auth::user()->id;
        $data = Transaction::where('user_id',$id)->paginate(10);
        return admin_view('transaction',compact('data'));
    }

    public function deleteTransaction(Request $request){
        $id = $request->id;
        Transaction::destroy($id);
    }
}
