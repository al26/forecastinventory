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
            return DB::table('materials')->select('material_type', 'material_name', 'material_stock')->get();
        });
        return view('inventory::production.materialstock')->with('data', $datamaterial);
    }

    public function formpurchasingmaterial()
    {
        $datamaterial = Cache::rememberForever('CacheMaterialsForInput',  function () {
            return DB::table('materials')->select('material_code', 'material_name')->get();
        });

        return view('inventory::logistic.formmaterialbuyment')->with('data', $datamaterial);
    }

    public function savepurchase(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tanggal_beli' => 'required|date',
            'bahanbaku' => 'required',
            'nominal' => 'required|numeric',
            'jumlah_stock' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'error');
        }


        if ($this->HandleInsertDataBuyment($request)) {
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
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'error');
        }
        if ($this->HandleUpdateDataBuyment($request, $id)) {
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
    protected function HandlePurchaseDelete($id)
    {
        DB::beginTransaction();
        $dataBuyment = DB::table('materials as M')->leftJoin('materials_buyment as MB', 'M.material_code', '=', 'MB.material_code')->select('M.material_stock as material_stock', 'MB.buyment_total as buyment_total', 'MB.material_code as material_code')->where('MB.buyment_code', '=', $id)->get();
        $dataUpdateMaterial = DB::table('materials')->where('material_code', '=', $dataBuyment[0]->material_code)->update(['material_stock' => $dataBuyment[0]->material_stock - $dataBuyment[0]->buyment_total]);
        $databuyment = DB::table('materials_buyment')->where('buyment_code', '=', $id)->delete();

        return ($dataUpdateMaterial && $databuyment ? true : false);
    }
    protected function HandleInsertDataBuyment(Request $request)
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
    protected function HandleUpdateDataBuyment(Request $request, $id)
    {
        DB::beginTransaction();

        $GetCurrentDataMaterials = DB::table('materials')->select('materials.material_stock')->where('materials.material_code', $request->bahanbaku)->get();
        $GetCurrentDataMaterialsBuyment = DB::table('materials_buyment')->select('materials_buyment.buyment_total')->where('materials_buyment.buyment_code', $id)->get();
        $updateDataMaterial = DB::table('materials')->where('material_code', $request->bahanbaku)->update(['material_stock' => $GetCurrentDataMaterials[0]->material_stock - $GetCurrentDataMaterialsBuyment[0]->buyment_total + $request->jumlah_stock]);
        $updateDataMaterialBuyment = DB::table('materials_buyment')->where('buyment_code', $id)->update(['buyment_total' => $request->jumlah_stock]);
        return ($updateDataMaterial && $updateDataMaterialBuyment ? true : false);
    }
}
