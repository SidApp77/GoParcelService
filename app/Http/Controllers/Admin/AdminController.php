<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('admin.dashboard'); 
    }

    public function staff()
    {
        return view('admin.staff.list');
    }

    public function vehicle()
    {
        return view('admin.vehicle.list');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.auth.login');
        // return redirect()->route('account.login')->with('success', 'Logout successful!');
    }


}
