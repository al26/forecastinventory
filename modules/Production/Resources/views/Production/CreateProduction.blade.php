@extends('layouts.admin')
@section('title',$title)
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
    <strong>{{$title}}</strong>
    </div>
    
    @if (isset($edit))
    <form action="{{route('updateproduction',['role'=>Auth::user()->getRoleNames()[0],'id'=>$edit[0]->id])}}" method="post" class="form-horizontal">
        @method('patch')    
    @else
    <form action="{{route('saveproduction',['role'=>Auth::user()->getRoleNames()[0]])}}" method="post" class="form-horizontal">
    @endif
            @csrf
            <div class="card-body card-block">
                <div class="row form-group"> 
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Periode</label></div>
                    <div class="col-12 col-md-4"><input type="text" id="text-input"
                    value="{{isset($edit[0]->periode)? $edit[0]->periode:''}}"
                            name="periode" class="form-control" placeholder="Periode">
                        <small class="form-text text-danger">{{ $errors->error->first('periode') }}</small>
                        {{-- <small class="form-text text-muted">kolom ini untuk nominal/jumlah harga bahan baku</small> --}}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Jumlah
                            Stock</label></div>
                    <div class="col-12 col-md-4"><input type="text" id="text-input"
                            value="{{isset($edit[0]->jumlah_product)? $edit[0]->jumlah_product:''}}"
                            name="jumlah" class="form-control" onkeypress="javascript:return isNumberKey(event);" placeholder="Jumlah">
                        <small class="form-text text-danger">{{ $errors->error->first('jumlah_stock') }}</small>
                        {{-- <small class="form-text text-muted">form ini untuk jumlah barang yang dibeli</small> --}}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-2"><label for="select" class=" form-control-label">Bahan Baku</label>
                    </div>
                    <div class="col-12 col-md-4">
                        <select name="product" id="select" class="form-control">
                            <option>Pilih Product</option>
                            @foreach ($data as $item)
                        <option value="{{$item->id}}" {{isset($edit[0]->product_id) && $edit[0]->product_id ==$item->id ? "selected":"" }}>{{$item->product_name}}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-danger">{{ $errors->error->first('bahanbaku') }}</small>
                        
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