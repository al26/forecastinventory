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
        $data['breadcrumb'] = true;
        return view('layouts.admin', $data);
    }

    public function logistic() { 
        $data['title'] = ucwords('Dasbor Logistik'); 
        $data['breadcrumb'] = true;
        return view('layouts.admin', $data);
    }
}