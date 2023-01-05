<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

class HomeController extends BackController
{
    public function index(Request $request)
    {
        return view('backend.index');
    }
}
