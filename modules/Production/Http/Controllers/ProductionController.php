<?php

namespace Modules\Production\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Session;

class ProductionController extends Controller
{

    public function production()
    {
        $dataproduct = Cache::rememberForever('productiondata',  function () {
            return DB::table('production as prd')
                ->select('prd.id', 'prd.periode', 'prd.jumlah_product', 'p.product_name')
                ->join('products AS p', 'prd.product_id', 'p.id')
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
            "periode" => "required|numeric",
            "jumlah" => "required",
            "product" => "required"
        ], [
            'periode.required'  => ucwords('Kolom periode wajib diisi.'),
            'periode.numeric'   => ucwords('Periode harus berupa angka.'),
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
            return redirect()->route('production');
        } else {
            DB::rollBack();
            Session::flash('message', ucwords('Gagal Menambah data production'));
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('production');
        }
    }
    public function deleteproduction($id)
    {
        if ($this->handleDelete($id)) {
            Session::flash('message', 'Berhasil Menghapus data production');
            Session::flash('type', 'info');
            DB::commit();
            Cache::flush();
            return redirect()->route('production');
        } else {
            DB::rollBack();
            Session::flash('message', 'Gagal Menghapus data production');
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('production');
        }
    }
    public function editproduction($id)
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
    public function updateproduction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "periode" => "required|numeric",
            "jumlah" => "required",
            "product" => "required"
        ], [
            'periode.required'  => ucwords('Kolom periode wajib diisi.'),
            'periode.numeric'   => ucwords('Periode harus berupa angka.'),
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
            return redirect()->route('production');
        } else {
            DB::rollBack();
            Session::flash('message', ucwords('Gagal Mengubah data production'));
            Session::flash('type', 'danger');
            Cache::flush();
            return redirect()->route('production');
        }
    }
    public function processProduction()
    {
        $periodeProduksi = DB::table('production as prd')->select('prd.periode', 'prd.id as production_id', 'prd.jumlah_product', 'pro.product_name')->join('products as pro', 'prd.product_id', '=', 'pro.id')->get();

        $productionToProduct = DB::table('production as prd')
            ->join('products as pro', 'prd.product_id', '=', 'pro.id')
            ->select('prd.id as id_production', 'prd.jumlah_product as jumlah_production', 'prd.periode as periode_production', 'pro.product_name as product_name', 'pro.id as product_id');

        $productionToMaterialneed = DB::table('productmaterialneed as pmn')->select('pmn.material_need as kebutuhan_material', 'id_production', 'jumlah_production', 'periode_production', 'product_name', 'productionToProduct.product_id', 'pmn.material_code as kode_material')
            ->leftJoinSub($productionToProduct, 'productionToProduct', function ($join) {
                $join->on('pmn.product_id', '=', 'productionToProduct.product_id');
            });

        $MaterialneedToMaterial = DB::table('materials as mtr')->select('kebutuhan_material', 'id_production', 'jumlah_production', 'periode_production', 'product_name', 'product_id', 'kode_material', 'mtr.unit as unit', 'mtr.material_name as material_name', 'mtr.material_stock as stock_material')
            ->joinSub($productionToMaterialneed, 'ProductionToMaterialneed', function ($join) {
                $join->on('mtr.material_code', '=', 'ProductionToMaterialneed.kode_material');
            })->get();
        $data['production'] = $periodeProduksi;
        $data['data'] = $MaterialneedToMaterial;
        $data['title'] = ucwords("Data Kebutuhan material Produksi");
        return view('production::Production.ProductionMaterial', $data);
        // return $periodeProduksi;
    }
    public function getProductionPeriode($id)
    {
        $productionToProduct = DB::table('production as prd')
            ->join('products as pro', 'prd.product_id', '=', 'pro.id')
            ->select('prd.id as id_production', 'prd.jumlah_product as jumlah_production', 'prd.periode as periode_production', 'pro.product_name as product_name', 'pro.id as product_id')
            ->where('prd.id', '=', $id);

        $productionToMaterialneed = DB::table('productmaterialneed as pmn')->select('pmn.material_need as kebutuhan_material', 'id_production', 'jumlah_production', 'periode_production', 'product_name', 'productionToProduct.product_id', 'pmn.material_code as kode_material')
            ->leftJoinSub($productionToProduct, 'productionToProduct', function ($join) {
                $join->on('pmn.product_id', '=', 'productionToProduct.product_id');
            });

        $MaterialneedToMaterial = DB::table('materials as mtr')->select('kebutuhan_material', 'id_production', 'jumlah_production', 'periode_production', 'product_name', 'product_id', 'kode_material', 'mtr.unit as unit', 'mtr.material_name as material_name', 'mtr.material_stock as stock_material')
            ->joinSub($productionToMaterialneed, 'ProductionToMaterialneed', function ($join) {
                $join->on('mtr.material_code', '=', 'ProductionToMaterialneed.kode_material');
            })->get();

        return $MaterialneedToMaterial;
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
            'jumlah_product' => $request->jumlah
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
