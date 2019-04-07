@extends('layouts.admin')
@section('title',$title)
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
    <strong>{{$title}}</strong>
    </div>
    <form action="{{route('updatematerial',$material[0]->material_code)}}" method="post" class="form-horizontal">
        @method('patch')
        
        @csrf
            <div class="card-body card-block">

                <div class="row form-group">
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Nama Bahanbaku</label>
                    </div>
                <div class="col-12 col-md-3"><input type="text" id="text-input" value="{{$material[0]->material_name}}" placeholder="Nama Bahanbaku" name="nama_material"
                            class="form-control">
                        <small class="form-text text-danger">{{ $errors->error->first('nama_material') }}</small>
                        {{-- <small class="form-text text-muted">Kolom ini untuk tanggal pembelian bahan baku</small> --}}
                    </div>
                </div>

                
                <div class="row form-group">
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Unit Bahanbaku</label>
                    </div>
                <div class="col-12 col-md-3"><input type="text" id="text-input" value="{{$material[0]->unit}}" placeholder="Unit Bahanbaku" name="unit_material"
                            class="form-control">
                        <small class="form-text text-danger">{{ $errors->error->first('nama_material') }}</small>
                        {{-- <small class="form-text text-muted">Kolom ini untuk tanggal pembelian bahan baku</small> --}}
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-2"><label for="select" class=" form-control-label">Jenis Bahanbaku</label>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="tipe_material" id="select" class="form-control">
                            <option value="">Pilih Jenis Bahanbaku</option>
                            
                            @foreach ($material_type as $item)
                                <option value="{{$item->material_type}}" {{isset($material[0]->material_type) && ($item->material_type === $material[0]->material_type) ? 'selected'  :'' }}>{{$item->material_type}}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-danger">{{ $errors->error->first('tipe_product') }}</small>
                        
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-2"><label for="text-input" class=" form-control-label">Stock Bahanbaku</label>
                    </div>
                <div class="col-12 col-md-3"><input type="text" id="text-input" value="{{$material[0]->material_stock}}" placeholder="Stock Bahanbaku" name="material_stock"
                            class="form-control">
                        <small class="form-text text-danger">{{ $errors->error->first('material_stock') }}</small>
                        {{-- <small class="form-text text-muted">Kolom ini untuk tanggal pembelian bahan baku</small> --}}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">
                    simpan
                </button>
                <button type="reset" class="btn btn-danger btn-sm">
                     Ulangi
                </button>
            </div>
        </form>
</div>

<!-- end content -->
<!-- Right Panel -->
@stop