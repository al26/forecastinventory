<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function administrator() {
        $data['title'] = ucwords('admin dashboard');
        $data['breadcrumb'] = true;
        return view('layouts.admin', $data);
    }

    public function production() { 
        $data['title'] = ucwords('prod dashboard'); 
        return view('layouts.admin');
    }

    public function logistic() { 
        $data['title'] = ucwords('log dashboard'); 
        return view('layouts.admin');
    }
}