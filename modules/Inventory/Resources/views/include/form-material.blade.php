<div id="formAfter">
    @foreach ($datamaterial as $item => $value)
    <div class="row form-group" id="inputMaterial{{$value->material_code}}"> 
            <div class="col col-md-2">
                <label for="select" class=" form-control-label">{{$value->material_name}}</label>
            </div>
            <div class="col-12 col-md-3">
                <input type="text" id="text-input" onkeypress="javascript:return isNumberKey(event);" value="" required placeholder="{{$value->unit}}" name="{{$value->material_code}}" class="form-control">
                <small class="form-text text-danger">{{ $errors->error->first('nama_product') }}</small>
                {{-- <small class="form-text text-muted">Kolom ini untuk tanggal pembelian bahan baku</small> --}}
            </div>
            <div class="col-12 col-md-3">
            <button type="button" onclick="removeInputMaterial(`{{$value->material_code}}`)" class="btn btn-primary btn-sm">Hapus</button>
            </div>
        </div>            
    @endforeach
</div>