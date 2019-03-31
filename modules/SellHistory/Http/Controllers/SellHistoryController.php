<?php

namespace Modules\SellHistory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Inventory\Entities\Products;
use Modules\SellHistory\Entities\SellHistory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class SellHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        Cache::flush();
        $data['title'] = ucwords('data penjualan');
        $data['products'] = Products::select('product_code', 'product_name')->get();
        $data['sell_histories'] = Cache::rememberForever('CacheSellHistory',  function () {
            // return SellHistory::select('product_code', 'period', 'amount')->get();
            return SellHistory::productSellHistory();
        });
        // dd($data);
        return view('sellhistory::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['title'] = ucwords('tambah data penjualan');
        $data['products'] = Products::select('product_code', 'product_name')->get();
        $data['last_period'] = SellHistory::select('period')->orderBy('id', 'desc')->take(1);
        // dd($data);
        return view('sellhistory::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request = $request->sh;
        $validator = Validator::make($request, [
            'period.required'       => 'Kolom periode wajib diisi.',
            'period.numeric'        => 'Periode harus berupa angka.',
            'product_code.required' => 'Kolom produk wajib diisi.',
            'amount.required'       => 'Kolom jumlah penjualan wajib diisi.'
        ]);

        if(!$validator->fails()) {
            $sh = new SellHistory;
            $sh->period = $request['period'];
            $sh->product_code = $request['product_code'];
            $sh->amount = $request['amount'];
    
            // DB::beginTransaction();
            if($sh->save()) {
                // DB::commit();
                Session::flash('type', 'success');
                Session::flash('message', 'Berhasil menambah data penjualan periode '.$request['period']);
                return redirect()->route('sh.index');
            }
            // DB::rollback();
            Session::flash('type', 'danger');
            Session::flash('message', 'Gagal menambah data penjualan periode '.$request['period']);
            return redirect()->back();
        }

        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('sellhistory::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('sellhistory::edit');
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
        return "delete $id";
    }
}
