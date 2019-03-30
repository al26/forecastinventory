<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function administrator() {
        $data['title'] = ucwords('Dasbor Admin');
        $data['breadcrumb'] = true;
        return view('layouts.admin', $data);
    }

    public function production() { 
        $data['title'] = ucwords('Dasbor Produksi'); 
        return view('layouts.admin');
    }

    public function logistic() { 
        $data['title'] = ucwords('Dasbor Logistik'); 
        return view('layouts.admin');
    }
}