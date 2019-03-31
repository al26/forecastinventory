@extends('layouts.admin')
@section('title','Formulir Pembelian Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
        <strong>Penambahan Product Baru</strong>
    </div>
    @if (isset($dataBuyment))
    <form action="{{route('updatepurchase',$dataBuyment[0]->buyment_code)}}" method="post" class="form-horizontal">
        @method('patch')
        @else
        <form action="{{route('saveproduct')}}" method="post" class="form-horizontal">


            @endif
            @csrf
            <div class="card-body card-block">

                <div class="row form-group">
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Nama Product</label>
                    </div>
                    <div class="col-12 col-md-3"><input type="text" id="text-input" value="" placeholder="nama produk" name="nama_product"
                            class="form-control">
                        <small class="form-text text-danger">{{ $errors->error->first('nama_product') }}</small>
                        {{-- <small class="form-text text-muted">Kolom ini untuk tanggal pembelian bahan baku</small> --}}
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-2"><label for="select" class=" form-control-label">Jenis Product</label>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="bahanbaku" id="select" class="form-control">
                            <option value="">Pilih Jenis Product</option>
                            <option value=""></option>
                        </select>
                        <small class="form-text text-danger">{{ $errors->error->first('bahanbaku') }}</small>
                        {{-- <small class="form-text text-muted">kolom ini untuk memilih bahan baku yang dibeli</small> --}}
                    </div>
                </div>
            </div>
            <div class="card-header">
                <strong>Kebutuhan Bahan Baku Product</strong>
            </div>
            <div class="card-body card-block">
                {{-- form kebutuhan material --}}
                @foreach ($data as $item =>$value)
                <div class="row form-group"> 
                    <div class="col col-md-2">
                        <div class="form-check">
                            <div class="checkbox">
                                <label for="checkbox1" class="form-check-label">
                                <input type="checkbox" id="checkbox1" name="checkbox1" value="{{$value->material_code}}"
                                        class="form-check-input">
                                {{$value->material_name}}</label>
                            </div>
                        </div>
                    </div>
                <div class="col-12 col-md-3"><input type="text" id="text-input" value="" placeholder="{{$value->unit}}" name="material_total"
                            class="form-control">
                        <small class="form-text text-danger">{{ $errors->error->first('nama_product') }}</small>
                        {{-- <small class="form-text text-muted">Kolom ini untuk tanggal pembelian bahan baku</small> --}}
                    </div>
                </div>
                @endforeach
                {{-- end form kebutuhan material --}}
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