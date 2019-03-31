<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function getDataProduct()
    {
        $dataproduct = Cache::rememberForever('CacheProduct',  function () {
            return DB::table('products')->select('product_name', 'product_type')->get();
        });
        return view('inventory::production.productview')->with('data', $dataproduct);
    }
    public function addDataProduct()
    {
        $datamaterial = Cache::rememberForever('CacheMaterialDataForInsertProduct',  function () {
            return DB::table('materials')->select('material_code', 'material_name', 'unit')->get();
        });
        
        return view('inventory::production.form-new-product')->with('data', $datamaterial);
    }
    public function saveproduct(Response $response){


    }
}
