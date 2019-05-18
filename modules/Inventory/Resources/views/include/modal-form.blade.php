<div class="modal-body">
        <div class="row form-group">
        <div class="col col-md-6">
                <div class="row">
                        <div class="col col-md-12">
                             <div class="row">
                                     <div class="col col-md-12">
                                             <label class=" form-control-label"><h5>Pilih Bahan baku</h5></label>
                                             <hr>
                                         </div>
                             </div>
                     </div>     
                        <div class="col col-md-12">
                             <div class="row">
                                    @foreach ($datamaterial as $item => $value)
                                     <div class="col col-md-6">
                                             <div class="form-check">
                                                
                                                     <div class="checkbox">
                                                         <label for="checkbox1" class="form-check-label ">
                                                         <input type="checkbox" onclick="selectedMaterial('{{$value->material_code}}')" name="check" data-code="{{$value->material_code}}" data-unit="{{$value->unit}}" value="{{$value->material_code}}" class="form-check-input checkboxMaterial">{{$value->material_name}}
                                                     </label>
                                                     </div>
                                                 
                                             </div>
                                         </div>
                                         @endforeach
                                        @csrf
                             </div>   
                         </div>     
                 </div>
        </div>
        <div class="col col-md-6" id="openFormAdd">
                <label class=" form-control-label"><h5>Tambah Bahan baku</h5></label>
                <hr>
            <form method="POST">
                @php
                    $url = route('adddatamaterial',Auth::user()->getRoleNames()[0]);
                @endphp
                @php
                    $url2 = route('getdatamaterial',Auth::user()->getRoleNames()[0]);
                @endphp
                <div class="row form-group">
                    <div class="col col-md-12">
                        <input type="text" id="" name="material-name" placeholder="Masukan Nama bahan baku" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-12">
                        <input type="text" id="" name="material-tipe" placeholder="Masukan Tipe bahan baku" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-12">
                        <input type="text" id="" name="material-unit" placeholder="Masukan satuan unit" class="form-control">
                    </div>
                </div>
                @csrf
                <div class="row form-group">
                    <div class="col col-md-3">
                    <button type="button" id="btnTambahMaterial" data-url="{{$url2}}" onclick="submitMaterial(`{{$url}}`)" class="btn btn-primary">Tambah</button>
                    </div>
                    <div class="col col-md-3">
                        <button type="reset" class="btn btn-danger">Atur Ulang</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>