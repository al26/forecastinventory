<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    private $json;

    function __construct() {
        $this->json = json_decode(file_get_contents(base_path('resources/json/guide.json')), true);
    }

    public function administrator() {
        $data['title'] = ucwords('Dasbor Admin');
        $data['breadcrumb'] = true;
        $data['guide'] = $this->json['administrator'];
        return view('layouts.partials.admin.guide', $data);
    }

    public function production() { 
        $data['title'] = ucwords('Dasbor Produksi');
        $data['breadcrumb'] = true;
        $data['guide'] = $this->json['production']; 
        return view('layouts.partials.admin.guide', $data);
    }

    public function logistic() { 
        $data['title'] = ucwords('Dasbor Logistik');
        $data['breadcrumb'] = true;
        $data['guide'] = $this->json['logistic']; 
        return view('layouts.partials.admin.guide', $data);
    }
}