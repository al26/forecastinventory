<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function getDataProduct()
    {
        $dataproduct = Cache::rememberForever('CacheProduct',  function () {
            return DB::table('products')->select('product_code','product_name', 'product_type')->get();
        });
        return view('inventory::production.productview')->with('data', $dataproduct);
    }
    public function addDataProduct()
    {
        
        $dataTypeProduct = Cache::rememberForever('CacheDataProductTypeForInsertProduct',  function () {    
            return  DB::table('products')->select('product_type')->groupBy('product_type')->get();
        });
        
        $dataMaterialProduct = Cache::rememberForever('CacheDataProductForInsertProduct',  function () {    
            return DB::table('materials')->select('material_code', 'material_name', 'unit')->get();
        });
        
        return view('inventory::production.form-new-product')->with('datamaterial', $dataMaterialProduct)->with('dataproduct',$dataTypeProduct);
    }
    public function saveproduct(Request $request){
        
        if($this->beginInsertData($request)){
            
            Session::flash('message', 'Berhasil Menambah data product');
            Session::flash('type', 'info');
            DB::commit();
            Cache::flush();
            return redirect()->route('productview');
        }else{
            DB::rollBack();
            Session::flash('message', 'Gagal manambah data product');
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('productview');
        }
    }
    public function deleteproduct($id){

        if ($this->HandleDeleteProduct($id)) {
            Session::flash('message', 'Berhasil Menghapus data Product');
            Session::flash('type', 'info');
            Cache::flush();
            DB::commit();
            return redirect()->route('productview');
        } else {
            Session::flash('message', 'Gagal menghapus data Product');
            Session::flash('type', 'danger');
            Cache::flush();
            DB::rollBack();
            return redirect()->route('productview');
        }
    }
    public function editproduct($id){
        echo "$id masuk ke edit form";
    }


    protected function beginInsertData(Request $request){
        DB::beginTransaction();
        $id = DB::table('products')->insertGetId(
            [
                'product_name'=>$request->nama_product,
                'product_type'=>$request->tipe_product
            ]
        );
        
        $c = DB::table('materials')->max('material_code');
        $datamaping = $this->Mappingdata($c,$request);

        foreach ($datamaping as $key => $value) {
        $insertMaterialNeed = DB::table('productmaterialneed')->insert(
                ['material_code'=>$value['code_material'], 'product_code'=>$id,'material_need'=>$value['kebutuhan_material']]
            );
        }
        return ($id && $insertMaterialNeed ? true : false);
    }
    protected function Mappingdata($c,$request){
        $arrayMap = [];
        for($i=1; $i<=$c; $i++){
            if($request->$i !== null){
                $a = [
                    'code_material'=>$i,
                    'kebutuhan_material'=>$request->$i
                ];
                array_push($arrayMap,$a);
                }
            }
        return $arrayMap;        
    }
    protected function HandleDeleteProduct($id)
    {
        DB::beginTransaction();
        $dataProduct = DB::table('products')->where('product_code', '=',$id)->delete();
        return ($dataProduct ? true : false);
    }

    
}
