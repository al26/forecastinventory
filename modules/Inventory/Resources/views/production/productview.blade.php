@extends('layouts.admin')
@section('title','Data Produk')
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
        <strong class="card-title">Data Produk</strong>
    <a href="{{route('adddataproduct',['role'=>Auth::user()->getRoleNames()[0]])}}" class="btn btn-primary btn-sm float-right">Tambah Data Baru</a>
    </div>
    <div class="card-body">
        <table id="bootstrap-data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Jenis Produk</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($data as $key => $value)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$value->product_name}}</td>
                    <td>{{$value->product_type}}</td>
                    <td>
                    <a href="{{route('editproduct',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->id])}}" class="btn btn-primary btn-sm" onclick="updateProductMaterial()"><i class="fas fa-fw fa-edit"></i></a>
                        <a delete-text="Hapus data pembelian ?"
                             class="btn btn-danger btn-sm" 
                             href="{{ route('deletedataproduct',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->id]) }}" 
                             onclick="javascript:swalDelete(this, event);">
                            <i class="fas fa-fw fa-trash-alt"></i> 
                            <form id="deleteMaterial" action="{{route('deletedataproduct',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->id])}}" method="post">
                                    @method('delete')
                                    @csrf
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
