<?php

namespace AV_Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AV_Core\Http\Controllers\Controller;

class ManagementMemberController extends Controller
{
    public function index()
    {
        return admin_view('management_member');
    }
}
