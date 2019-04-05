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
    public function getDataProduct(){
        $dataproduct = Cache::rememberForever('CacheProduct',  function () {
            return DB::table('products')->select('id','product_name', 'product_type')->get();
        });
        return view('inventory::production.productview')->with('data', $dataproduct);
    }
    public function addDataProduct(){
        $data['datamaterial']=$this->dataMaterialProduct();
        $data['dataproduct']=$this->dataTypeProduct();
        return view('inventory::production.form-new-product',$data);
                // ->with('datamaterial', $this->dataMaterialProduct())
                // ->with('dataproduct',$this->dataTypeProduct());
    }
    public function saveproduct(Request $request){
        
        if($this->handleInsertData($request)){
            
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
        $dataedit = DB::table('products')->select('id','product_name','product_type')->where('id', '=',$id)->get();
        
        $condition = DB::table('productmaterialneed as p')
                   ->select('*')
                   ->where('p.product_id','=',$id);
        
        $dataeditmaterial = DB::table('materials as m')
                    ->select('m.material_code','m.material_name','m.unit','condition.material_need')
                    ->leftJoinSub($condition, 'condition', function ($join) {
                        $join->on('m.material_code', '=', 'condition.material_code');
                    })->get();
        $data['dataproduct']=$this->dataTypeProduct();
        $data['datamaterial']=$dataeditmaterial;
        $data['dataedit']=$dataedit;
        return view('inventory::production.form-new-product',$data);
                // ->with('dataproduct',$this->dataTypeProduct())
                // ->with('datamaterial',$dataeditmaterial)
                // ->with('dataedit',$dataedit);
    }
    public function updateproduct(Request $request,$id){
       
        if($this->handleUpdateData($request,$id)){
            Session::flash('message', 'Berhasil Mengubah data product');
            Session::flash('type', 'info');
            DB::commit();
            Cache::flush();
            return redirect()->route('productview');
        }else{
            DB::rollBack();
            Session::flash('message', 'Gagal Mengubah data product');
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('productview');
        }
    }

    private function handleUpdateData(Request $request, $id){
        DB::beginTransaction();
        DB::table('products')->where('id', $id)->update(['product_name' => $request->nama_product,'product_type'=>$request->tipe_product]);
        DB::table('productmaterialneed')->where('product_id',$id)->delete();
        $c = DB::table('materials')->max('material_code');
        $datamaping = $this->Mappingdata($c,$request);
        foreach ($datamaping as $key => $value) {
            $updateMaterialNeed = DB::table('productmaterialneed')->insert(
                    ['material_code'=>$value['code_material'],'product_id'=>$id,'material_need'=>$value['kebutuhan_material']]
                );
            }
            return ($id && $updateMaterialNeed ? true : false);
    }
    private function handleInsertData(Request $request){
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
                ['material_code'=>$value['code_material'], 'product_id'=>$id,'material_need'=>$value['kebutuhan_material']]
            );
        }
        return ($id && $insertMaterialNeed ? true : false);
    }
    private function Mappingdata($c,$request){
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
    private function HandleDeleteProduct($id){
        DB::beginTransaction();
        $dataProduct = DB::table('products')->where('id', '=',$id)->delete();
        return ($dataProduct ? true : false);
    }
    private function dataTypeProduct(){
        $dataTypeProduct = Cache::rememberForever('CacheDataProductTypeForInsertProduct',  function () {    
            return  DB::table('products')->select('product_type')->groupBy('product_type')->get();
        });
        return $dataTypeProduct;
    }
    private function dataMaterialProduct(){
        $dataMaterialProduct = Cache::rememberForever('CacheDataProductForInsertProduct',  function () {    
            return DB::table('materials')->select('material_code', 'material_name', 'unit')->get();
        });
        return $dataMaterialProduct;
    }

    
}
