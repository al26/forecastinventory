<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Inventory\Entities\bahanbaku;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class BahanbakuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function persediaanbahanbaku(){
        $databahanbaku = DB::table('bahanbaku')->select('jenis_bahanbaku','nama_bahanbaku','jumlah_stock')->get();
        return view('inventory::production.persediaanbahanbaku')->with('data',$databahanbaku);
    }

    
    public function formpembelianbahanbaku()
    {
        $databahanbaku = DB::table('bahanbaku')->select('kode_bahanbaku','nama_bahanbaku')->get();
        return view('inventory::logistic.formpembelianbahanbaku')->with('data',$databahanbaku);
    }

    public function simpanpembelian(Request $request){
        
        $validator = Validator::make($request->all(), [
            'tanggal_beli' => 'required|date',
            'bahanbaku' => 'required',
            'nominal' => 'required|numeric',
            'jumlah_stock'=>'required|numeric'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator, 'error');
        }
        
        $insertpembelian = DB::table('pembelian_bahanbaku')->insert([
            'kode_bahanbaku' => $request->bahanbaku,
            'jumlah_pembelian'=> $request->jumlah_stock,
            'nominal_pembelian' => $request->nominal,
            'tanggal_pembelian' => $request->tanggal_beli
        ]);
        if($insertpembelian){
            Session::flash('message', 'Berhasil memasukan data pembelian'); 
            Session::flash('type', 'info'); 
            return redirect()->route('datapembelian');
        }else{
            Session::flash('message', 'Gagal memasukan data pembelian'); 
            Session::flash('type', 'danger'); 
            return redirect()->route('datapembelian');
        }
    }
    
    public function datapembelian(){
        $datapembelian = DB::table('pembelian_bahanbaku')
                        ->select('pembelian_bahanbaku.tanggal_pembelian as tanggal_beli','bahanbaku.nama_bahanbaku as bahan_baku','pembelian_bahanbaku.jumlah_pembelian as Jumlah','pembelian_bahanbaku.nominal_pembelian as Nominal')
                        ->leftJoin('bahanbaku', 'bahanbaku.kode_bahanbaku', '=', 'pembelian_bahanbaku.kode_bahanbaku')->get();
         
        return view('inventory::logistic.datapembelian')->with('data',$datapembelian);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('inventory::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('inventory::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('inventory::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
