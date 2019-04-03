@extends('layouts.admin')
@section('title','Data Persediaan Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
        <strong class="card-title">Data Product</strong>
    <a href="{{route('adddataproduct')}}" class="btn btn-primary btn-sm float-right">Tambah Data Baru</a>
    </div>
    <div class="card-body">
        <table id="bootstrap-data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Product</th>
                    <th>Jenis Product</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($data as $key => $value)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$value->product_name}}</td>
                    <td>{{$value->product_type}}</td>
                    <td>
                    <a href="{{route('editproduct',$value->product_code)}}" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i></a>
                        <a delete-text="Hapus data pembelian ?"
                             class="btn btn-danger btn-sm" 
                             href="{{ route('deletedataproduct',$value->product_code) }}" 
                             onclick="javascript:swalDelete(this, event);">
                            <i class="fas fa-fw fa-trash-alt"></i> 
                            <form id="deleteMaterial" action="{{route('deletedataproduct',$value->product_code)}}" method="post">
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
