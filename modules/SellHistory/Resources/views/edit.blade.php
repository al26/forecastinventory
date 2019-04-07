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
                    <form action="{{route('sh.update', ['id' => $sell_history->id])}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @method('patch')
                        @csrf
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="product_id" class=" form-control-label">Produk</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="hidden" name="sh[product_id]" value="{{$sell_history->product_id}}">
                                <input type="text" readonly class="form-control-plaintext font-weight-bolder" id="product_id" value="{{$sell_history->product_code." - ".$sell_history->product_name}}">
                                @if ($errors->has('product_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_id') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="period" class=" form-control-label">Periode</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="period" name="sh[period]" placeholder="periode penjualan" class="form-control{{ $errors->has('period') ? ' is-invalid' : '' }}"  onkeypress="javascript:return isNumberKey(event);" value="{{$sell_history->period}}">
                                @if ($errors->has('period'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('period') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="quarter" class=" form-control-label">Quarter</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="quarter" name="sh[quarter]" placeholder="quarter penjualan" class="form-control{{ $errors->has('quarter') ? ' is-invalid' : '' }}"  onkeypress="javascript:return isNumberKey(event);" value="{{$sell_history->quarter}}">
                                @if ($errors->has('quarter'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('quarter') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="amount" class=" form-control-label">Jumlah Penjualan</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="amount" name="sh[amount]" placeholder="jumlah penjualan" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" onkeypress="javascript:return isNumberKey(event);" value="{{$sell_history->amount}}">
                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                Ubah Data
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
    <script type="text/javascript" src="{{Module::asset('sellHistory:js/sellHistory.js')}}"></script>
@endsection