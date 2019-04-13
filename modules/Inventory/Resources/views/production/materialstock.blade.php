@extends('layouts.admin')
@section('title','Data Persediaan Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
        <strong class="card-title">Data Persediaan Bahan Baku</strong>
        {{-- <a href="#" class="btn btn-primary btn-sm float-right">Tambah Data Baru</a> --}}
    </div>
    <div class="card-body">
        <table id="bootstrap-data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Stok</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($data as $key => $value)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$value->material_name}}</td>
                    <td>{{$value->material_type}}</td>
                    <td>{{$value->material_stock}}</td>
                    <td>
                        <a get-title="Kurangi Stok {{$value->material_name}} ?" get-text="Manupulasi data bahan baku dapat menyebabkan pencatatan tidak valid. Data yang telah dihapus tidak dapat dikembalikan"
                            class="btn btn-danger btn-sm text-white" 
                            href="{{ route('reducematerial',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->material_code]) }}" 
                            onclick="javascript:swalGetdata(this, event);">
                           <i class="fas fa-fw fa-angle-double-down"></i> 
                           <form id="swalGetdata" action="{{route('reducematerial',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->material_code])}}" method="get">
                               </form>
                       </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- end content -->
<!-- Right Panel -->
@stop
