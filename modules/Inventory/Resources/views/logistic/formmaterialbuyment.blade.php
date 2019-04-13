@extends('layouts.admin')
@section('title','Formulir Pembelian Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
        <strong> Pembelian Bahan Baku</strong>
    </div>
    @if (isset($dataBuyment))
    <form action="{{route('updatepurchase',['role'=>Auth::user()->getRoleNames()[0],'id'=>$dataBuyment[0]->buyment_code])}}" method="post" class="form-horizontal">
        @method('patch')
        @else
        <form action="{{route('savepurchase',['role'=>Auth::user()->getRoleNames()[0]])}}" method="post" class="form-horizontal">


            @endif
            @csrf
            <div class="card-body card-block">

                <div class="row form-group">
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Tanggal
                            beli</label></div>

                    <div class="col-12 col-md-3"><input type="date" id="text-input"
                            value="<?php echo (isset($dataBuyment[0]->buyment_date) ? \Carbon\Carbon::createFromDate($dataBuyment[0]->buyment_date)->format('Y-m-d'):"") ?>"
                            name="tanggal_beli" class="form-control">
                        <small class="form-text text-danger">{{ $errors->error->first('tanggal_beli') }}</small>
                        {{-- <small class="form-text text-muted">Kolom ini untuk tanggal pembelian bahan baku</small> --}}
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-2"><label for="select" class=" form-control-label">Bahan Baku</label>
                    </div>
                    <div class="col-12 col-md-10">
                        <select name="bahanbaku" id="select" class="form-control">
                            <option value="">Pilih Bahan Baku</option>
                            @foreach ($data as $item)
                            <option value="{{$item->material_code}}" <?php echo(isset($dataBuyment[0]->material_code) ? ($item->material_code === $dataBuyment[0]->material_code ? 'selected'  :'' ) : "")?>>{{$item->material_name}}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-danger">{{ $errors->error->first('bahanbaku') }}</small>
                        {{-- <small class="form-text text-muted">kolom ini untuk memilih bahan baku yang dibeli</small> --}}
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Nominal</label></div>
                    <div class="col-12 col-md-5"><input type="text" id="text-input"
                            value="<?php echo (isset($dataBuyment[0]->buyment_price)? $dataBuyment[0]->buyment_price : "")?>"
                            name="nominal" class="form-control" onkeypress="javascript:return isNumberKey(event);" placeholder="Rupiah">
                        <small class="form-text text-danger">{{ $errors->error->first('nominal') }}</small>
                        {{-- <small class="form-text text-muted">kolom ini untuk nominal/jumlah harga bahan baku</small> --}}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Jumlah
                            Stock</label></div>
                    <div class="col-12 col-md-5"><input type="text" id="text-input"
                            value="<?php echo (isset($dataBuyment[0]->buyment_total) ? $dataBuyment[0]->buyment_total:"") ?>"
                            name="jumlah_stock" class="form-control" onkeypress="javascript:return isNumberKey(event);" placeholder="Jumlah">
                        <small class="form-text text-danger">{{ $errors->error->first('jumlah_stock') }}</small>
                        {{-- <small class="form-text text-muted">form ini untuk jumlah barang yang dibeli</small> --}}
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-dot-circle-o"></i> simpan
                </button>
                <button type="reset" class="btn btn-danger btn-sm">
                    <i class="fa fa-ban"></i> Ulangi
                </button>
            </div>
        </form>
</div>

<!-- end content -->
<!-- Right Panel -->
@stop