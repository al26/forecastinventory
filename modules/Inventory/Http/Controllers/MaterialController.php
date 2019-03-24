<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function materialstock(){
        $datamaterial = DB::table('materials')->select('material_type','material_name','material_stock')->get();
        return view('inventory::production.materialstock')->with('data',$datamaterial);
    }

    
    public function formpurchasingmaterial()
    {
        $datamaterial = DB::table('materials')->select('material_code','material_name')->get();
        return view('inventory::logistic.formmaterialbuyment')->with('data',$datamaterial);
    }

    public function savepurchase(Request $request){
        
        $validator = Validator::make($request->all(), [
            'tanggal_beli' => 'required|date',
            'bahanbaku' => 'required',
            'nominal' => 'required|numeric',
            'jumlah_stock'=>'required|numeric'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator, 'error');
        }
        
        $insertbuyment = DB::table('materials_buyment')->insert([
            'material_code' => $request->bahanbaku,
            'buyment_total'=> $request->jumlah_stock,
            'buyment_price' => $request->nominal,
            'buyment_date' => $request->tanggal_beli
        ]);
        if($insertbuyment){
            Session::flash('message', 'Berhasil memasukan data pembelian'); 
            Session::flash('type', 'info'); 
            return redirect()->route('purchasedata');
        }else{
            Session::flash('message', 'Gagal memasukan data pembelian'); 
            Session::flash('type', 'danger'); 
            return redirect()->route('purchasedata');
        }
    }
    
    public function purchasedata(){
        $databuyment = DB::table('materials_buyment')
                        ->select('materials_buyment.buyment_date as tanggal_beli','materials.material_name as bahan_baku','materials_buyment.buyment_total as Jumlah','materials_buyment.buyment_price as Nominal')
                        ->leftJoin('materials', 'materials.material_code', '=', 'materials_buyment.material_code')->get();
         
        return view('inventory::logistic.databuyment')->with('data',$databuyment);
    }

}
