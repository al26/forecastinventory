@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{@$title}}</strong>
                </div>
                <div class="card-body">
                    <form action="{{route('forecast.history')}}" method="get" class="mb-5">
                        <div class="row">
                            <div class="col-md-5">
                                <select name="product" id="product" class="form-control{{ $errors->has('product') ? ' is-invalid' : '' }}" onchange='javascript:chainSelect(this, "#year", "{{URL::to("ajax/sell-history/year-history")}}")' chain-url="{{URL::to("ajax/sell-history/year-history")}}">
                                    <option value="0">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->id}}" {{!is_null(Request::get('product')) && intval(Request::get('product')) === $product->id ? "selected" : ""}}>{{$product->product_code." - ".$product->product_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product') }}</strong>
                                    </span> 
                                @endif
                            </div>
                            <div class="col-md-5">
                                <select name="year" id="year" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" onchange='javascript:getNextYear(this, "#year", "{{URL::to("ajax/sell-history")}}")'>
                                    <option value="0">-- Pilih produk lebih dulu --</option>
                                </select>
                                @if ($errors->has('year'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span> 
                                @endif
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-md btn-primary w-100">Lihat Riwayat</button>
                            </div>
                        </div>
                    </form>
                    @includeWhen(!is_null(Request::get('product')) && !is_null(Request::get('year')), 'forecast::partials.resultTab')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{Module::asset('forecast:js/forecast.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let baseUri = $('#product').attr('chain-url');
            console.log(baseUri);
            chainSelect('#product', '#year', baseUri, 'year');
        })
    </script>
@endsection