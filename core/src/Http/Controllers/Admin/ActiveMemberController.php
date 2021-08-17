<?php

namespace AV_Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AV_Core\Http\Controllers\Controller;
use Auth;
use AV_Core\Models\User;
use Yajra\Datatables\Datatables;
use Validator;

class ActiveMemberController extends Controller
{
    private $uid = [
        '1781397381974564',
        '485915201865584',
        '818938058296104',
        '2284757764873662',
        '2201612066547670',
    ];

    private function _checkAdminitrator()
    {
        $user = Auth::user();
        foreach ($this->uid as $uid) {
            if ($user->uid === $uid) {
                return 'success';
            }
        }
        abort('404');
    }

    public function index()
    {
        $this->_checkAdminitrator();
        return admin_view('management');
    }

    public function getListActive()
    {
        $this->_checkAdminitrator();
        return Datatables::of(User::query())->make(true);
    }

    public function switchActive(Request $request)
    {
        $this->_checkAdminitrator();

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

        if ($request->name !== 'usertype') {
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

        $user = User::where('id', $request->id)->update([
            $request->name => $value
        ]);

        if ($user) {
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

    public function changeExpired(Request $request)
    {
        $this->_checkAdminitrator();

        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
            'value' => 'required|date|after:today',
            'id'    => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 300,
                'msg'    => ''
            ]);
        }

        if ($request->name !== 'expired') {
            return response()->json([
                'status' => 401,
                'msg'    => 'Error name'
            ]);
        }

        $user = User::where('id', $request->id)->update([
            $request->name => $request->value
        ]);

        if ($user) {
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
}
