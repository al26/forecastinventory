<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\Materials;


class ProductsController extends Controller
{
    
    public function getDataProduct(){
        $dataproduct = Cache::rememberForever('CacheProduct',  function () {
            return DB::table('products')->select('id','product_name', 'product_type')->get();
        });
        $data['data']=$dataproduct;
        return view('inventory::production.productview',$data);
    }
    public function addDataProduct($role=null){
        $data['datamaterial']=$this->dataMaterialProduct();
        $data['dataproduct']=$this->dataTypeProduct();
        return view('inventory::production.form-new-product',$data);
                // ->with('datamaterial', $this->dataMaterialProduct())
                // ->with('dataproduct',$this->dataTypeProduct());
    }
    public function getDataMaterial($role=null,Request $request){
        // $code = $request->has("selectedMaterial") ? $request->input("selectedMaterial") : null;
        if($request->has("selectedMaterial")){
            $code = $request->input("selectedMaterial");
        }else if($request->has("material_code")){
            $code = is_array($request->material_code) && count($request->material_code) > 0
                    ? !in_array(null, $request->material_code) ? $request->material_code : null
                    : null;
        }else{
            $code = null;
        }
        
        $datamaterial = $this->dataMaterialProduct($code);
        $view = view("inventory::include.modal-form",compact('datamaterial'))->render();
        return response()->json($view);
    }
    public function addDataMaterial(Request $request){
        $validator = Validator::make($request->all(), [
            'materail_name' => 'alpha_num'
        ],[
            'materail_name.alpha_num'=>ucwords('kolom kode produk harus berupa angka dan huruf'),
            ]);
            if (!$validator->fails()) {
                $result = $this->handleAddMaterial($request);
                 if(isset($result)){
                     DB::commit();
                     Cache::flush();
                     return response()->json(['data'=>$result,'status'=>true]);
                 }else{
                     DB::rollBack();
                     return response()->json(['data'=>null,'status'=>false]);     
                 }
                // return $result;
            }else{
                return response()->json(['data'=>null,'status'=>false]);
            }
    }
    public function getMaterialSelected(Request $request){
        $code = [];
        if($request->has("material_code")) {
            if(!is_array($request->input("material_code"))) {
                $code = [];
            } else {
                $code = $request->input("material_code");
            }
        }
        // dd($code);
        $datamaterial = Materials::select('material_code', 'material_name','unit')
        ->whereIn('material_code', $code);
        if(count($code) > 0) {
            $datamaterial = $datamaterial->orderByRaw(\DB::raw("FIELD(material_code, ".implode(",",$code).")"));
        }
        $datamaterial = $datamaterial->get();
        // $datamaterial = $this->dataMaterialProduct($request->material_code);
        // return response()->json($data);
        if($request->data_action === "update"){
            $data = $datamaterial->pluck('material_code')->toArray();
            $view = view("inventory::include.form-update-material",compact('datamaterial'))->render();
            return response()->json(['html'=>$view,'data'=>$data]);    
        }
        $data = $datamaterial->pluck('material_code')->toArray();
        $view = view("inventory::include.form-material",compact('datamaterial'))->render();
        return response()->json(['html'=>$view,'data'=>$data]);
        // return $data;
    }
    private function handleAddMaterial($request){
        DB::beginTransaction();
        $result = DB::table('materials')->insert(
            [
                'material_name'=>$request->material_name,
                'material_type'=>$request->material_type,
                'material_stock'=>0,
                'unit'=>$request->material_unit
            ]
        );
        return $result;
        
    }
    public function saveproduct($role=null,Request $request){
        
        $validator = Validator::make($request->all(), [
            'product_code' => 'required|alpha_num',
            'nama_product' => 'required',
            'tipe_product' => 'required'
        ],[
            'product_code.required'=>ucwords('kolom kode produk harus diisi'),
            'product_code.alpha_num'=>ucwords('kolom kode produk harus berupa angka dan huruf'),
            'nama_product.required'=>ucwords('kolom nama produk harus diisi'),
            'tipe_product.required'=>ucwords('kolom tipe produk harus diisi')
            ]);
            if (!$validator->fails()) {
                $result = $this->handleInsertData($request);
            }else{
                return redirect()->back()->withErrors($validator, 'error');
            }
        if($result){
            
            Session::flash('message', ucwords('Berhasil Menambah data product'));
            Session::flash('type', 'info');
            DB::commit();
            Cache::flush();
            return redirect()->route('productview',['role'=>Auth::user()->getRoleNames()[0]]);
        }else{
            DB::rollBack();
            Session::flash('message', ucwords('Gagal manambah data product'));
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('productview',['role'=>Auth::user()->getRoleNames()[0]]);
        }
    }
    public function deleteproduct($role=null,$id){

        if ($this->HandleDeleteProduct($id)) {
            Session::flash('message', ucwords('Berhasil Menghapus data Product'));
            Session::flash('type', 'info');
            Cache::flush();
            DB::commit();
            return redirect()->route('productview',['role'=>Auth::user()->getRoleNames()[0]]);
        } else {
            Session::flash('message', ucwords('Gagal menghapus data Product'));
            Session::flash('type', 'danger');
            Cache::flush();
            DB::rollBack();
            return redirect()->route('productview',['role'=>Auth::user()->getRoleNames()[0]]);
        }
    }
    public function editproduct($role=null,$id){
        $dataedit = DB::table('products')->select('id','product_name','product_code','product_type')->where('id', '=',$id)->get();
        
        $condition = DB::table('productmaterialneed as p')
                   ->select('*')
                   ->where('p.product_id','=',$id);
        
        $dataeditmaterial = DB::table('materials as m')
                    ->select('m.material_code','m.material_name','m.unit','condition.material_need')
                    ->rightJoinSub($condition, 'condition', function ($join) {
                        $join->on('m.material_code', '=', 'condition.material_code');
                    })->get();
        $data['dataproduct']=$this->dataTypeProduct();
        $data['datamaterial']=$dataeditmaterial;
        $data['dataedit']=$dataedit;
        return view('inventory::production.form-update-product',$data);
    }
    public function updateproduct($role=null,Request $request,$id){
       
        if($this->handleUpdateData($request,$id)){
            Session::flash('message', ucwords('Berhasil Mengubah data product'));
            Session::flash('type', 'info');
            DB::commit();
            Cache::flush();
            return redirect()->route('productview',['role'=>Auth::user()->getRoleNames()[0]]);
        }else{
            DB::rollBack();
            Session::flash('message', ucwords('Gagal Mengubah data product'));
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('productview',['role'=>Auth::user()->getRoleNames()[0]]);
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
        // return true;
    }
    private function handleInsertData(Request $request){
        DB::beginTransaction();
        $id = DB::table('products')->insertGetId(
            [
                'product_name'=>$request->nama_product,
                'product_type'=>$request->tipe_product,
                'product_code'=>$request->product_code
            ]
        );
        
        $c = DB::table('materials')->max('material_code');
        $datamaping = $this->Mappingdata($c,$request);
        foreach ($datamaping as $key => $value) {
        $insertMaterialNeed = DB::table('productmaterialneed')->insert(
                ['material_code'=>$value['code_material'], 'product_id'=>$id,'material_need'=>$value['kebutuhan_material']]
            );
        }
        if(isset($insertMaterialNeed)){
            return ($id && $insertMaterialNeed ? true : false);
        }else{
            redirect()->back();
        }
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
    private function dataMaterialProduct($code = null){
        if($code === null) {
            return DB::table('materials')
                ->select('material_code', 'material_name', 'unit')
                ->get();
        }    
            
        if($code !== null && is_array($code) && count($code) > 0){
            return  DB::table('materials')
            ->select('material_code', 'material_name', 'unit')
            ->whereNotIn('material_code', $code)
            ->orderByRaw(\DB::raw("FIELD(material_code, ".implode(",",$code).")"))
            ->get();
        }

        // return $result;
    }

    
}
