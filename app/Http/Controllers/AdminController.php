<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showIndexAdmin()
    {
        return view('admin.index');
    }
    
}
