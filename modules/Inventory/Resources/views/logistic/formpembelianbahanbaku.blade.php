@extends('layouts.admin')
@section('title','Formulir Pembelian Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
        <strong> Pembelian Bahan Baku</strong>
    </div>
    <form action="{{route('savepembelian')}}" method="post" class="form-horizontal">
        @csrf
        <div class="card-body card-block">

            <div class="row form-group">
                <div class="col col-md-2"><label for="text-input" class=" form-control-label">Tanggal
                        beli</label></div>
                <div class="col-12 col-md-3"><input type="date" id="text-input" name="tanggal_beli"
                        class="form-control">
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
                        <option value="{{$item->kode_bahanbaku}}">{{$item->nama_bahanbaku}}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-danger">{{ $errors->error->first('bahanbaku') }}</small>
                    {{-- <small class="form-text text-muted">kolom ini untuk memilih bahan baku yang dibeli</small> --}}
                </div>
            </div>

            <div class="row form-group">
                <div class="col col-md-2"><label for="text-input" class=" form-control-label">Nominal</label></div>
                <div class="col-12 col-md-5"><input type="text" id="text-input" name="nominal" class="form-control">
                    <small class="form-text text-danger">{{ $errors->error->first('nominal') }}</small>
                    {{-- <small class="form-text text-muted">kolom ini untuk nominal/jumlah harga bahan baku</small> --}}
                </div>
            </div>
            <div class="row form-group">
                <div class="col col-md-2"><label for="text-input" class=" form-control-label">Jumlah
                        Stock</label></div>
                <div class="col-12 col-md-5"><input type="text" id="text-input" name="jumlah_stock"
                        class="form-control">
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
