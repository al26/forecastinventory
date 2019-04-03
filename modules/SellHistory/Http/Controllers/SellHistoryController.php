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
        $data['products'] = Products::select('product_id', 'product_name')->get();
        $data['sell_histories'] = Cache::rememberForever('CacheSellHistory',  function () {
            // return SellHistory::select('product_id', 'period', 'amount')->get();
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
        $data['products'] = Products::select('product_id', 'product_name')->get();
        $data['last_period'] = SellHistory::getLastPeriod();
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
        $validator = Validator::make($request,[
            "period" => "required|numeric",
            "amount" => "required",
            "product_id" => [
                "required",
                function ($attribute, $value, $fail) {
                    if ($value === '0') {
                        $fail('Silahkah pilih produk yang tersedia.');
                    }
                },
            ]
        ], [
            'period.required'       => 'Kolom periode wajib diisi.',
            'period.numeric'        => 'Periode harus berupa angka.',
            'product_id.required' => 'Kolom produk wajib diisi.',
            'amount.required'       => 'Kolom jumlah penjualan wajib diisi.'
        ]);

        if(!$validator->fails()) {
            $sh = new SellHistory;
            $sh->period = $request['period'];
            $sh->quarter = $request['quarter'];
            $sh->product_id = $request['product_id'];
            $sh->amount = $request['amount'];
    
            // DB::beginTransaction();
            if($sh->save()) {
                // DB::commit();
                Cache::flush();
                Session::flash('type', 'success');
                Session::flash('message', 'Berhasil menambah data penjualan periode');
                return redirect()->route('sh.index');
            }
            // DB::rollback();
            Session::flash('type', 'danger');
            Session::flash('message', 'Gagal menambah data penjualan periode');
            return redirect()->back();
        }

        // dd($validator->errors());
        return redirect()->back()
                         ->withErrors($validator->errors())
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
        $data['title'] = ucwords('ubah data penjualan');
        $data['products'] = Products::select('product_id', 'product_name')->get();
        $data['sell_history'] = SellHistory::productSellHistory(['id' => $id]);
        return view('sellhistory::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request = $request->sh;
        $validator = Validator::make($request,[
            "period" => "required|numeric",
            "quarter" => "required|numeric",
            "amount" => "required",
            "product_id" => [
                "required",
                function ($attribute, $value, $fail) {
                    if ($value === '0') {
                        $fail('Silahkah pilih produk yang tersedia.');
                    }
                },
            ]
        ], [
            'period.required'       => 'Kolom periode wajib diisi.',
            'period.numeric'        => 'Periode harus berupa angka.',
            'product_id.required' => 'Kolom produk wajib diisi.',
            'amount.required'       => 'Kolom jumlah penjualan wajib diisi.'
        ]);

        if(!$validator->fails()) {
            $sh = SellHistory::find($id);
            $sh->period = $request['period'];
            $sh->product_id = $request['product_id'];
            $sh->amount = $request['amount'];
    
            // DB::beginTransaction();
            if($sh->save()) {
                // DB::commit();
                Cache::flush();
                Session::flash('type', 'success');
                Session::flash('message', 'Berhasil mengubah data penjualan');
                return redirect()->route('sh.index');
            }
            // DB::rollback();
            Session::flash('type', 'danger');
            Session::flash('message', 'Gagal mengubah data penjualan periode');
            return redirect()->back();
        }

        // dd($validator->errors());
        return redirect()->back()
                         ->withErrors($validator->errors())
                         ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $d = SellHistory::find($id);
        if ($d->delete()) {
            Session::flash('message', "Berhasil menghapus data penjualan");
            Session::flash('type', "success");
        } else {
            Session::flash('message', "Gagal menghapus data penjualan");
            Session::flash('type', "danger");
        }

        return redirect()->route('sh.index');
    }

    public function getLastPeroidOfProduct(Request $request, $product) {
        return SellHistory::getLastPeriod(['product_id' => $product]);
    }
}
