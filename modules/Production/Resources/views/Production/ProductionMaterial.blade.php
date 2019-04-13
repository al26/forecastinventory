

@extends('layouts.admin')
@section('title',$title)
@section('content')
<!-- Right Panel -->
<!-- begin content -->


<div class="card">
    <div class="card-header">
    <strong class="card-title">{{$title}}</strong>
    {{-- <a href="{{route('addproduction')}}" class="btn btn-primary btn-sm float-right">Tambah Data
            Baru</a> --}}
    </div>
    <div class="card-body">
        <table id="production-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Periode</th>
                    <th>Tahun</th>
                    <th>Nama Produk</th>
                    <th>Jumlah Produksi</th>
                    <th>Opsi</th>
                    
                </tr>
            </thead>
            <tbody>

                @foreach ($production as $key => $value)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{ucfirst($value->periode)}}</td>
                    <td>{{$value->year}}</td>
                    <td>{{$value->product_name}}</td>
                    <td>{{$value->jumlah_product}}</td>
                    <td>
                        <a href="{{route('getProductionData',['id'=>$value->production_id])}}" class="btn btn-info btn-sm buttonProduction" data-toggle="collapse" type="button" aria-expanded="false" aria-controls="collapseExample" ><i class="far fa-fw fa-eye text-white"></i></a>
                    </td>
                </tr>
                {{-- <tr class="collapse" id="collapseExample{{$value->periode}}">
                        <td colspan="5">
                                @include('production::Partials.collapse')
                            </td>
                    
                </tr> --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- end content -->
<!-- Right Panel -->
@stop
@section('script')
<script src="{{Module::asset('Production:js/production.js')}}"></script>    
@endsection
