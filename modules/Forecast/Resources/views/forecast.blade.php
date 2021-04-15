@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{@$title}}</strong>
                    <a href="" class="btn btn-sm btn-primary float-right">Batal</a>
                </div>
                <div class="card-body card-block">
                    <form action="{{route('forecast')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class=" form-control-label">Produk</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="fc[product_id]" id="select" class="form-control{{ $errors->has('product_id') ? ' is-invalid' : '' }}" onchange='javascript:getNextYear(this, "#year", "{{URL::to("ajax/sell-history")}}")'>
                                    <option value="0">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->id}}" {{is_null($product->rows) || intval($product->rows) < 12 ? "disabled" : ""}}>{{$product->product_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_id') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="fc[year]" value="" id="year">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="alpha" class=" form-control-label">Variabel</label>
                            </div>
                            <div class="col-md-9">
                                <div class="col-md-4 px-md-0 pr-md-2">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white">
                                                <img src="{{asset('images/alfa.png')}}" alt="alfa" class="img-fluid" width="15">
                                            </span>
                                        </div>
                                        <input type="text" id="alpha" name="fc[alpha]" placeholder="nilai alpha" class="form-control{{ $errors->has('alpha') ? ' is-invalid' : '' }}"  onkeypress="javascript:return isNumberKey(event);" value="0">
                                    </div>
                                    @if ($errors->has('alpha'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('alpha') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                                <div class="col-md-4 px-md-1">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white">
                                                <img src="{{asset('images/beta.png')}}" alt="alfa" class="img-fluid" width="13">
                                            </span>
                                        </div>
                                        <input type="text" id="beta" name="fc[beta]" placeholder="nilai beta" class="form-control{{ $errors->has('beta') ? ' is-invalid' : '' }}"  onkeypress="javascript:return isNumberKey(event);" value="0">
                                    </div>
                                    @if ($errors->has('beta'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('beta') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                                <div class="col-md-4 px-md-0 pl-md-2">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white" id="basic-addon1">
                                                <img src="{{asset('images/gama.png')}}" alt="alfa" class="img-fluid" width="20">
                                            </span>
                                        </div>
                                        <input type="text" id="gamma" name="fc[gamma]" placeholder="nilai gamma" class="form-control{{ $errors->has('gamma') ? ' is-invalid' : '' }}"  onkeypress="javascript:return isNumberKey(event);" value="1">
                                    </div>
                                    @if ($errors->has('gamma'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('gamma') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="period" class=" form-control-label">Periode Penjualan</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="fc[period]" id="period" class="form-control{{ $errors->has('period') ? ' is-invalid' : '' }}">
                                    <option value="0" disabled>-- Pilih Produk --</option>
                                </select>
                                @if ($errors->has('period'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('period') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div> --}}
                        <div class="row form-group">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary btn-sm {{count($check) < 1 ? "disabled" : ""}}" {{count($check) < 1 ? "disabled" : ""}}>
                                Ramal
                                </button>
                                <button type="reset" class="btn btn-danger btn-sm">
                                Atur Ulang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{Module::asset('sellhistory:js/sellHistory.js')}}"></script>
@endsection