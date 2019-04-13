<?php

namespace Modules\Production\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
{

    public function production($role =null)
    {
        // Cache::flush();
        $dataproduct = Cache::rememberForever('productiondata',  function () {
            return DB::table('production as prd')
                ->select('prd.id', 'prd.periode', 'prd.year', 'prd.jumlah_product', 'prd.status', 'p.product_name')
                ->join('products AS p', 'prd.product_id', 'p.id')
                ->orderBy('prd.year', 'desc')
                ->orderBy('prd.id', 'asc')
                ->get();
        });
        $data['data'] = $dataproduct;
        $data['title'] = ucwords("Data Kebutuhan Produksi");
        return view('production::Production.ProductionData', $data);
    }
    public function addProduction()
    {
        $dataproduct = Cache::rememberForever('products',  function () {
            return DB::table('products')->select('id', 'product_name')->get();
        });
        $data['data'] = $dataproduct;
        $data['title'] = ucwords("Tambah Data Produksi");

        return view('production::Production.CreateProduction', $data);
    }
    public function saveProduction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "periode" => "required",
            "jumlah" => "required",
            "product" => "required"
        ], [
            'periode.required'  => ucwords('Kolom periode wajib diisi.'),
            'jumlah.required'   => ucwords('Kolom jumlah wajib diisi.'),
            'product.required'  => ucwords('Kolom produk wajib diisi.')
        ]);
        if (!$validator->fails()) {
            $result = $this->handleSave($request);
        } else {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        if ($result) {
            Session::flash('message', ucwords('Berhasil Menambah data production'));
            Session::flash('type', 'info');
            DB::commit();
            Cache::flush();
            return redirect()->route('production',['role'=>Auth::user()->getRoleNames()[0]]);
        } else {
            DB::rollBack();
            Session::flash('message', ucwords('Gagal Menambah data production'));
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('production',['role'=>Auth::user()->getRoleNames()[0]]);
        }
    }
    public function deleteproduction($role = null,$id)
    {
        if ($this->handleDelete($id)) {
            Session::flash('message', 'Berhasil Menghapus data production');
            Session::flash('type', 'info');
            DB::commit();
            Cache::flush();
            return redirect()->route('production',['role'=>Auth::user()->getRoleNames()[0]]);
        } else {
            DB::rollBack();
            Session::flash('message', 'Gagal Menghapus data production');
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('production',['role'=>Auth::user()->getRoleNames()[0]]);
        }
    }
    public function editproduction($role =null, $id)
    {
        $dataedit = DB::table('production as prd')
            ->select('prd.id', 'prd.periode', 'prd.jumlah_product', 'p.id as product_id')
            ->join('products AS p', 'prd.product_id', 'p.id')
            ->where('prd.id', '=', $id)
            ->get();
        $dataproduct = Cache::rememberForever('products',  function () {
            return DB::table('products')->select('id', 'product_name')->get();
        });
        $data['data'] = $dataproduct;
        $data['edit'] = $dataedit;
        $data['title'] = ucwords("Ubah Data Produksi");

        return view('production::Production.CreateProduction', $data);
    }
    public function updateproduction(Request $request, $role =null, $id)
    {
        $validator = Validator::make($request->all(), [
            "periode" => "required",
            "jumlah" => "required",
            "product" => "required"
        ], [
            'periode.required'  => ucwords('Kolom periode wajib diisi.'),
            'jumlah.required'   => ucwords('Kolom jumlah wajib diisi.'),
            'product.required'  => ucwords('Kolom produk wajib diisi.')
        ]);
        if (!$validator->fails()) {
            $result = $this->handleUpdate($request, $id);
        } else {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        if ($result) {
            Session::flash('message', ucwords('Berhasil Mengubah data production'));
            Session::flash('type', 'info');
            DB::commit();
            Cache::flush();
            return redirect()->route('production',['role'=>Auth::user()->getRoleNames()[0]]);
        } else {
            DB::rollBack();
            Session::flash('message', ucwords('Gagal Mengubah data production'));
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('production',['role'=>Auth::user()->getRoleNames()[0]]);
        }
    }

    public function runningProduction()
    {
        $periodeProduksi = DB::table('production as prd')->select('prd.periode', 'prd.id as production_id', 'prd.jumlah_product','prd.year',  'pro.product_name')->join('products as pro', 'prd.product_id', '=', 'pro.id')->where('prd.status', '=', 'berjalan')->get();
        $data['production'] = $periodeProduksi;
        $data['title'] = ucwords("Data Kebutuhan material Produksi Berjalan");
        return view('production::Production.ProductionMaterial', $data);
    }
    public function finishProduction()
    {
        $periodeProduksi = DB::table('production as prd')->select('prd.periode', 'prd.id as production_id', 'prd.jumlah_product','prd.year', 'pro.product_name')->where('prd.status', '=', 'selesai')->join('products as pro', 'prd.product_id', '=', 'pro.id')->get();
        $data['production'] = $periodeProduksi;
        $data['title'] = ucwords("Data Kebutuhan material Produksi Selesai");
        return view('production::Production.ProductionMaterial', $data);
    }

    public function getProductionPeriode($id)
    {

        $productionToProduct = DB::table('production as prd')
            ->join('products as pro', 'prd.product_id', '=', 'pro.id')
            ->select('prd.id as id_production', 'prd.jumlah_product as jumlah_production', 'prd.periode as periode_production', 'pro.product_name as product_name', 'pro.id as product_id');

        $productionToMaterialneed = DB::table('productmaterialneed as pmn')->where('id_production', '=', $id)->select('pmn.material_need as kebutuhan_material', 'id_production', 'jumlah_production', 'periode_production', 'product_name', 'productionToProduct.product_id', 'pmn.material_code as kode_material')
            ->leftJoinSub($productionToProduct, 'productionToProduct', function ($join) {
                $join->on('pmn.product_id', '=', 'productionToProduct.product_id');
            });

        $MaterialneedToMaterial = DB::table('materials as mtr')->select('kebutuhan_material', 'id_production', 'jumlah_production', 'periode_production', 'product_name', 'product_id', 'kode_material', 'mtr.unit as unit', 'mtr.material_name as material_name', 'mtr.material_stock as stock_material')
            ->joinSub($productionToMaterialneed, 'ProductionToMaterialneed', function ($join) {
                $join->on('mtr.material_code', '=', 'ProductionToMaterialneed.kode_material');
            })
            ->get();
        return $MaterialneedToMaterial;
    }
    public function changeProductionStatus($role=null,$id)
    {

        if ($this->handleStatus($id)) {
            Session::flash('message', ucwords('Berhasil Mengubah status production'));
            Session::flash('type', 'info');
            DB::commit();
            Cache::flush();
            return redirect()->route('production',['role'=>Auth::user()->getRoleNames()[0]]);
        } else {
            DB::rollBack();
            Session::flash('message', ucwords('Gagal Mengubah Status production'));
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('production',['role'=>Auth::user()->getRoleNames()[0]]);
        }
    }
    private function handleStatus($id)
    {
        DB::beginTransaction();
        $dataProduction = $this->getProductionPeriode($id);
        foreach ($dataProduction as $key => $value) {
            $kodeMaterial = $value->kode_material;
            $newStock = $value->stock_material - ($value->jumlah_production * $value->kebutuhan_material);
            DB::table('materials')->where('material_code', '=', $kodeMaterial)->update([
                'material_stock' => $newStock
            ]);
        }
        $updateStatusProduction = DB::table('production')->where('id', '=', $id)->update([
            'status' => ucwords("selesai"),
        ]);

        // dd($dataProduction);
        return ($updateStatusProduction ? true : false);
    }
    private function handleUpdate($request, $id)
    {
        DB::beginTransaction();
        $updateFromProduction = DB::table('production')->where('id', '=', $id)->update([
            'periode' => $request->periode,
            'product_id' => $request->product,
            'jumlah_product' => $request->jumlah
        ]);
        return ($updateFromProduction ? true : false);
    }
    private function handleSave($request)
    {
        DB::beginTransaction();
        $insertToProduction = DB::table('production')->insert([
            'periode' => $request->periode,
            'product_id' => $request->product,
            'jumlah_product' => $request->jumlah,
            'status' => ucwords("berjalan"),
        ]);
        return ($insertToProduction ? true : false);
    }
    private function handleDelete($id)
    {
        DB::beginTransaction();
        $result = DB::table('production')->where('id', '=', $id)->delete();
        return ($result ? true : false);
    }
}
