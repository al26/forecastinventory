@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{@$title}}</strong>
                </div>
                <div class="card-body card-block">
                    <form action="{{route('sh.store')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="period" class=" form-control-label">Periode</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="period" name="sh[period]" placeholder="periode penjualan" class="form-control{{ $errors->has('sh.period') ? ' is-invalid' : '' }}" value="{{isset($last_period->period) ? $last_period->period : 1 }}" onkeypress="javascript:return isNumberKey(event);">
                                @if ($errors->has('sh.period'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('sh.period') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class=" form-control-label">Produk</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="sh[product_code]" id="select" class="form-control{{ $errors->has('sh.product_code') ? ' is-invalid' : '' }}">
                                    <option value="0">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->product_code}}">{{$product->product_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('sh.product_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('sh.product_code') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="amount" class=" form-control-label">Jumlah Penjualan</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="amount" name="sh[amount]" placeholder="jumlah penjualan" class="form-control{{ $errors->has('sh.amount') ? ' is-invalid' : '' }}" onkeypress="javascript:return isNumberKey(event);">
                                @if ($errors->has('sh.amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('sh.amount') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 offset-md-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-dot-circle-o"></i> Submit
                                </button>
                                <button type="reset" class="btn btn-danger btn-sm">
                                <i class="fas fa-ban"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection