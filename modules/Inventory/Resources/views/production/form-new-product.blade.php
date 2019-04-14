@extends('layouts.admin')
@section('title','Formulir Pembelian Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
        <strong>Penambahan Product Baru</strong>
    </div>

    @if (isset($dataedit))
    <form action="{{route('updateproduct',['role'=>Auth::user()->getRoleNames()[0],'id'=>$dataedit[0]->id])}}" method="post" class="form-horizontal">
        @method('patch')
        
    @else
    <form action="{{route('savedataproduct',['role'=>Auth::user()->getRoleNames()[0]])}}" method="post" class="form-horizontal">
        
    @endif
        @csrf
            <div class="card-body card-block">

                <div class="row form-group">
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Nama Product</label>
                    </div>
                    <div class="col-12 col-md-3"><input type="text" id="text-input" value="<?php echo (isset($dataedit[0]->product_name)? $dataedit[0]->product_name : "")?>" placeholder="nama produk" name="nama_product"
                            class="form-control">
                        <small class="form-text text-danger">{{ $errors->error->first('nama_product') }}</small>
                        {{-- <small class="form-text text-muted">Kolom ini untuk tanggal pembelian bahan baku</small> --}}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Kode Product </label>
                    </div>
                    <div class="col-12 col-md-3"><input type="text" id="text-input" value="<?php echo (isset($dataedit[0]->product_code)? $dataedit[0]->product_code : "")?>" placeholder="kode product" name="product_code"
                            class="form-control">
                        <small class="form-text text-danger">{{ $errors->error->first('product_code') }}</small>
                        {{-- <small class="form-text text-muted">Kolom ini untuk tanggal pembelian bahan baku</small> --}}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-2"><label for="select" class=" form-control-label">Jenis Product</label>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="tipe_product" id="select" class="form-control">
                            <option value="">Pilih Jenis Product</option>
                            @foreach ($dataproduct as $item => $value)
                                <option value="{{$value->product_type}}" <?php echo(isset($dataedit[0]->product_type) ? ($value->product_type === $dataedit[0]->product_type ? 'selected'  :'' ) : "")?>>{{$value->product_type}}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-danger">{{ $errors->error->first('tipe_product') }}</small>
                        {{-- <small class="form-text text-muted">kolom ini untuk memilih bahan baku yang dibeli</small> --}}
                    </div>
                </div>
            </div>
            <div class="card-header">
                <strong>Kebutuhan Bahan Baku Product</strong>
            </div>
            <div class="card-body card-block">
                {{-- form kebutuhan material --}}
                
                @foreach ($datamaterial as $item => $value)
                <div class="row form-group"> 
                <div class="col col-md-2">
                <label for="select" class=" form-control-label">{{$value->material_name}}</label>
                </div>
                <div class="col-12 col-md-3">
                    <input type="text" id="text-input" onkeypress="javascript:return isNumberKey(event);" value="{{ isset($value->material_need) ? $value->material_need : ""}}" placeholder="{{$value->unit}}" name="{{$value->material_code}}" class="form-control">
                    <small class="form-text text-danger">{{ $errors->error->first('nama_product') }}</small>
                        {{-- <small class="form-text text-muted">Kolom ini untuk tanggal pembelian bahan baku</small> --}}
                    </div>
                </div>
                
                @endforeach
                {{-- end form kebutuhan material --}}
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">
                    Simpan
                </button>
                <button type="reset" class="btn btn-danger btn-sm">
                    Atur Ulang
                </button>
            </div>
        </form>
</div>

<!-- end content -->
<!-- Right Panel -->
@stop