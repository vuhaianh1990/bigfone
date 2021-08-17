<?php

namespace AV_Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AV_Core\Http\Controllers\Controller;
use Auth;
use AV_Core\Models\User;
use AV_Core\Models\DataUser;
use Validator;
use Yajra\Datatables\Datatables;

class ListScanController extends Controller
{
    public function index()
    {
        // Get User
        $user      = Auth::user();
        $listUser = User::where('parent_id',$user->id)->get();
        $userArr[] = $user->id;
        if($listUser->count() > 0){
            foreach($listUser as $itemUser){
                $userArr[] = $itemUser->id;
            }

        }

        $dataUser  = DataUser::whereIn('user_id', $userArr)->get();

        $called     = 0;
        $wrongPhone = 0;
        $cotter     = 0;
        if ($dataUser->count() > 0) {
            foreach($dataUser as $item) {
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

        return admin_view('list-scan', [
            'dataUser'   => $dataUser->count(),
            'called'     => $called,
            'wrongPhone' => $wrongPhone,
            'cotter'     => $cotter
        ]);
    }

    public function getListScan(Request $request)
    {
        $user = Auth::user();
        $listUser = User::where('parent_id',$user->id)->get();
        $userArr[] = $user->id;
        if($listUser->count() > 0){
            foreach($listUser as $itemUser){
                $userArr[] = $itemUser->id;
            }

        }

        $data = DataUser::select([
            'id',
            'created_at',
            'name',
            'phone',
            // 'email',
            'link',
            'location',
            'gender',
            'health_care',
            'date_health_care',
            'called',
            'wrong_phone',
            'cotter'
        ])->whereIn('user_id', $userArr)->orderBy('created_at', 'desc');

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

    /**
     * Update Called | Wrong_Phone (Đã gọi | Nhầm số)
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function switchCall(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
            'value' => 'required|integer',
            'id'    => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'msg'    => $validator
            ]);
        }

        if ($request->name !== 'called'
                && $request->name !== 'wrong_phone'
                && $request->name !== 'cotter' ) {
            return response()->json([
                'status' => 401,
                'msg'    => 'Error name'
            ]);
        }

        if ($request->value == 0) {
            $value = 1;
        } else {
            $value = 0;
        }

        $dataUser = DataUser::where('id', $request->id)->update([
            $request->name => $value
        ]);

        if ($dataUser) {
            return response()->json([
                'status' => 200,
                'msg'    => 'Success'
            ]);
        }

        return response()->json([
            'status' => 400,
            'msg' => 'Not Change'
        ]);
    }


    public function changeData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'            => 'integer',
            'email'         => 'nullable|email',
            'gender'        => 'integer',
            'location'      => 'nullable|string',
            'work'          => 'nullable|string',
            'note'          => 'nullable|string',
            'called'        => 'integer',
            'wrong_phone'   => 'integer',
            'source'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'msg'       => $validator->validate()
            ]);
        }

        // Remove empty
        $res = array_filter($request->all());
        if(isset($res->note))
            $res->note = nl2br($request->note);
        $dataUser = DataUser::where('id', $request->id)->update($res);
        if ($dataUser) {
            return response()->json([
                'status'    => 200,
                'msg'       => 'Success'
            ]);
        }

        return response()->json([
            'status'    => 400,
            'msg'       => 'Not Change'
        ]);
    }
}
