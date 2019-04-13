@php
    $months = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
    $months = array_map(function($val){
        return ucfirst($val);
    }, $months);

    $quarter = 1;
@endphp
@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{@$title}}</strong>
                    <a href="{{route('sh.index')}}" class="btn btn-sm btn-primary float-right">Batal</a>
                </div>
                <div class="card-body card-block">
                    <form action="{{route('sh.store')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <div class="row form-group">
                            <div class="col-6">
                                <label for="select" class=" form-control-label">Produk</label>
                                <select name="sh[product_id]" id="select" class="form-control{{ $errors->has('product_id') ? ' is-invalid' : '' }}" onchange='javascript:getNextYear(this, "#year", "{{URL::to("ajax/sell-history")}}")' tabindex="1">
                                    <option value="0">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->id}}" {{old('sh.product_id') && $product->id === intval(old('sh.product_id')) ? "selected" : ""}}>{{$product->product_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_id') }}</strong>
                                    </span> 
                                @endif
                                <span class="form-text text-muted">
                                    Pilih produk. Saran tahun akan ditambahkan ke kolom Tahun secara otomatis. 
                                </span>
                            </div>
                            <div class="col-6">
                                <label for="year" class=" form-control-label">Tahun</label>
                                <input type="text" id="year" name="sh[year]" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" value="{{old('sh.year')}}" onkeypress="javascript:isNumberKey(this);" tabindex="2">
                                @if ($errors->has('year'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span> 
                                @endif
                                <span class="form-text text-muted">
                                    Ketik manual jika tahun yang hendak dimasukkan berbeda dengan saran tahun dari sistem. 
                                </span>
                            </div>
                        </div>
                        @foreach ($months as $index => $name)
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        @if ($loop->first)
                                            <label for="period" class=" form-control-label">Periode</label>
                                        @endif
                                        <input type="hidden" id="quarter{{$index}}" name="sh[quarter][{{$index}}]" placeholder="quarter penjualan" class="form-control{{ $errors->has('quarter.'.$index) ? ' is-invalid' : '' }}" value="{{old('sh.quarter.'.$index) ? old('sh.quarter.'.$index) : $quarter}}">
                                        <input type="text" id="period{{$index}}" name="sh[period][{{$index}}]" placeholder="periode penjualan" class="bg-white form-control{{ $errors->has('period.'.$index) ? ' is-invalid' : '' }}" value="{{old('sh.period.'.$index) ? old('sh.period.'.$index) : $name}}" readonly aria-readonly="true" tabindex="-1">
                                        @if ($errors->has('period.'.$index))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('period.'.$index) }}</strong>
                                            </span> 
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        @if ($loop->first)
                                            <label for="amount" class=" form-control-label">Jumlah Penjualan</label>
                                        @endif
                                        <input type="text" id="amount{{$index}}" name="sh[amount][{{$index}}]" placeholder="0" class="form-control{{ $errors->has('amount.'.$index) ? ' is-invalid' : '' }}" value="{{old('sh.amount.'.$index)}}" onkeypress="javascript:return isNumberKey(event);" tabindex="{{$index+3}}">
                                        @if ($errors->has('amount.'.$index))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount.'.$index) }}</strong>
                                            </span> 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @php
                                $quarter = $quarter < 4 ? $quarter+1 : 1;
                            @endphp
                        @endforeach
                        <div class="row form-group">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-sm" tabindex="{{count($months)+3}}">
                                Tambah Data
                                </button>
                                <button type="reset" class="btn btn-danger btn-sm" tabindex="{{count($months)+3}}">
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
    <script type="text/javascript" src="{{Module::asset('sellHistory:js/sellHistory.js')}}"></script>
@endsection