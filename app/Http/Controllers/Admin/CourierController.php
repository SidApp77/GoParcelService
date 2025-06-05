<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    //
    public function index()
    {
        return view('admin.courier.list');
    }
    
    public function category()
    {
        return view('admin.courier.category');
    }

    public function charges()
    {
        return view('admin.courier.charges');
    }


}
