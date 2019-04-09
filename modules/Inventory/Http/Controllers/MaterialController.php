<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function materialstock()
    {

        $datamaterial = Cache::rememberForever('CacheMaterialStock',  function () {
            return DB::table('materials')->select('material_code','material_type', 'material_name', 'material_stock')->get();
        });
        $data['data'] = $datamaterial; 
        return view('inventory::production.materialstock',$data);
    }

    public function formpurchasingmaterial()
    {
        $datamaterial = Cache::rememberForever('CacheMaterialsForInput',  function () {
            return DB::table('materials')->select('material_code', 'material_name')->get();
        });
        $data['data']=$datamaterial;
        return view('inventory::logistic.formmaterialbuyment',$data);
    }

    public function savepurchase(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tanggal_beli' => 'required|date',
            'bahanbaku' => 'required',
            'nominal' => 'required|numeric',
            'jumlah_stock' => 'required|numeric'
        ],[
            'tanggal_beli.required'=>ucwords('tanggal beli harus diisi'),
            'tanggal_beli.date'=>ucwords('tanggal beli harus berupa tanggal'),
            'bahanbaku.required'=>ucwords('kolom bahanbaku harus diisi'),
            'nominal.required'=>ucwords('kolom nominal harus diisi'),
            'nominal.numeric'=>ucwords('kolom nominal harus berupa numeric'),
            'jumlah_stock.required'=>ucwords('kolom jumlah stock harus diisi'),
            'jumlah_stock.numeric'=>ucwords('kolom jumlah stock harus berupa numeric')
            ]);
        if (!$validator->fails()) {
            $result = $this->HandleInsertDataBuyment($request);
        }else{
            return redirect()->back()->withErrors($validator, 'error');
        }

        if ($result) {
            DB::commit();
            Session::flash('message', 'Berhasil memasukan data pembelian');
            Session::flash('type', 'info');
            Cache::flush();
            return redirect()->route('purchasedata');
        } else {
            // Else commit the queries
            DB::rollBack();
            Session::flash('message', 'Gagal memasukan data pembelian');
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('purchasedata');
        }
    }

    public function purchasedata()
    {
        $databuyment = Cache::rememberForever('CacheForPurchaseDataMaterial',  function () {
            return  DB::table('materials_buyment')
                ->select('materials_buyment.buyment_code as kode_pembelian', 'materials_buyment.buyment_date as tanggal_beli', 'materials.material_name as bahan_baku', 'materials_buyment.buyment_total as Jumlah', 'materials_buyment.buyment_price as Nominal')
                ->leftJoin('materials', 'materials.material_code', '=', 'materials_buyment.material_code')->get();
        });

        return view('inventory::logistic.databuyment')->with('data', $databuyment);
    }

    public function purchasedelete($id)
    {

        if ($this->HandlePurchaseDelete($id)) {
            Session::flash('message', 'Berhasil Menghapus data pembelian');
            Session::flash('type', 'info');
            Cache::flush();
            DB::commit();
            return redirect()->route('purchasedata');
        } else {
            Session::flash('message', 'Gagal menghapus data pembelian');
            Session::flash('type', 'danger');
            Cache::flush();
            DB::rollBack();
            return redirect()->route('purchasedata');
        }
    }

    public function editpurchase($id)
    {
        $datamaterial = Cache::rememberForever('CacheMaterialsForInput',  function () {
            return DB::table('materials')->select('material_code', 'material_name')->get();
        });
        $dataBuymentEdit = DB::table('materials_buyment')->select('*')->where('buyment_code', '=', $id)->get();

        return view('inventory::logistic.formmaterialbuyment')->with('data', $datamaterial)->with('dataBuyment', $dataBuymentEdit);
    }

    public function updatepurchase(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_beli' => 'required|date',
            'bahanbaku' => 'required',
            'nominal' => 'required|numeric',
            'jumlah_stock' => 'required|numeric'
        ],[
            'tanggal_beli.required'=>ucwords('tanggal beli harus diisi'),
            'tanggal_beli.date'=>ucwords('tanggal beli harus berupa tanggal'),
            'bahanbaku.required'=>ucwords('kolom bahanbaku harus diisi'),
            'nominal.required'=>ucwords('kolom nominal harus diisi'),
            'nominal.numeric'=>ucwords('kolom nominal harus berupa numeric'),
            'jumlah_stock.required'=>ucwords('kolom jumlah stock harus diisi'),
            'jumlah_stock.numeric'=>ucwords('kolom jumlah stock harus berupa numeric')
            ]);
        if (!$validator->fails()) {
            $result = $this->HandleUpdateDataBuyment($request, $id);
        }else{
            return redirect()->back()->withErrors($validator, 'error');
        }

        if ( $result ) {
            DB::commit();
            Session::flash('message', 'Berhasil mengubah data pembelian');
            Session::flash('type', 'info');
            Cache::flush();
            return redirect()->route('purchasedata');
        } else {
            // Else commit the queries
            DB::rollBack();
            Session::flash('message', 'Gagal mengubah data pembelian');
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('purchasedata');
        }
    }

    public function getmaterialstock($id){
        $material_type = DB::table('materials')->select('material_type')->groupBy('material_type')->get()->toArray();
        $data['material'] = DB::table('materials')->select('material_type','material_code','material_name','material_stock','unit')->where('material_code','=',$id)->get();
        $data['title'] = ucwords("ubah stock material");
        return view('inventory::logistic.updatematerial',$data)->with('material_type',$material_type);
    }

    public function updatematerial(Request $request, $id){
        $validator = Validator::make($request->all(), [
            "nama_material" => "required",
            "tipe_material" => "required",
            "unit_material" => "required",
            "material_stock" => "required|numeric"
        ], [
            'nama_material.required'  => ucwords('Kolom Bahanbaku wajib diisi.'),
            'unit_material.required'  => ucwords('Kolom unit Bahanbaku wajib diisi.'),
            'tipe_material.required'   => ucwords('Kolom Tipe bahanbaku wajib diisi.'),
            'material_stock.required'  => ucwords('Kolom material wajib diisi.'),
            'material_stock.numeric'  => ucwords('Kolom stock material berupa angka.')
        ]);
        if (!$validator->fails()) {
            $result = $this->handleUpdate($request,$id);
        } else {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        if ($result) {
            Session::flash('message', ucwords('Berhasil Mengubah data Bahanbaku'));
            Session::flash('type', 'info');
            DB::commit();
            Cache::flush();
            return redirect()->route('materialstock');
        } else {
            DB::rollBack();
            Session::flash('message', ucwords('Gagal Mengubah data Bahanbaku'));
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('materialstock');
        }
    }

    public function materialNeedProduction(){
        $data['production'] = $this->handleMaterialneedProduction();
        $data['title'] = ucwords("Data Kebutuhan material Produksi Berjalan");
        return view('production::Production.ProductionMaterial', $data);
    }
    private function handleUpdate($request,$id){
        DB::beginTransaction();
        $materialupdate = DB::table('materials')->where('material_code','=',$id)->update(['material_stock'=>$request->material_stock,'material_name'=>$request->nama_material,'material_type'=>$request->tipe_material,'unit'=>$request->unit_material]);
        return ($materialupdate?"true":"false");
    }
    private function HandlePurchaseDelete($id)
    {
        DB::beginTransaction();
        $dataBuyment = DB::table('materials as M')->leftJoin('materials_buyment as MB', 'M.material_code', '=', 'MB.material_code')->select('M.material_stock as material_stock', 'MB.buyment_total as buyment_total', 'MB.material_code as material_code')->where('MB.buyment_code', '=', $id)->get();
        $dataUpdateMaterial = DB::table('materials')->where('material_code', '=', $dataBuyment[0]->material_code)->update(['material_stock' => $dataBuyment[0]->material_stock - $dataBuyment[0]->buyment_total]);
        $databuyment = DB::table('materials_buyment')->where('buyment_code', '=', $id)->delete();

        return ($dataUpdateMaterial && $databuyment ? true : false);
    }
    private function HandleInsertDataBuyment(Request $request)
    {
        DB::beginTransaction();
        $InsertToMaterialBuyment = DB::table('materials_buyment')->insert([
            'material_code' => $request->bahanbaku,
            'buyment_total' => $request->jumlah_stock,
            'buyment_price' => $request->nominal,
            'buyment_date' => $request->tanggal_beli
        ]);
        $GetCurrentDataMaterials = DB::table('materials')->select('materials.material_stock')->where('materials.material_code', $request->bahanbaku)->get();
        $UpdateStockMaterials = DB::table('materials')->where('material_code', $request->bahanbaku)->update(['material_stock' => $GetCurrentDataMaterials[0]->material_stock + $request->jumlah_stock]);
        return ($UpdateStockMaterials && $InsertToMaterialBuyment ? true : false);
    }
    private function HandleUpdateDataBuyment(Request $request, $id)
    {
        DB::beginTransaction();

        $GetCurrentDataMaterials = DB::table('materials')->select('materials.material_stock')->where('materials.material_code', $request->bahanbaku)->get();
        $GetCurrentDataMaterialsBuyment = DB::table('materials_buyment')->select('materials_buyment.buyment_total')->where('materials_buyment.buyment_code', $id)->get();
        $updateDataMaterial = DB::table('materials')->where('material_code', $request->bahanbaku)->update(['material_stock' => $GetCurrentDataMaterials[0]->material_stock - $GetCurrentDataMaterialsBuyment[0]->buyment_total + $request->jumlah_stock]);
        $updateDataMaterialBuyment = DB::table('materials_buyment')->where('buyment_code', $id)->update(['buyment_total' => $request->jumlah_stock]);
        return ($updateDataMaterial && $updateDataMaterialBuyment ? true : false);
    }
    private function handleMaterialneedProduction(){
        try {
            return DB::table('production as prd')->select('prd.periode', 'prd.id as production_id', 'prd.jumlah_product', 'pro.product_name')->join('products as pro', 'prd.product_id', '=', 'pro.id')->where('prd.status', '=', 'berjalan')->get();
        } catch (\Throwable $th) {
            return null;
        }
        
    }
}
