@extends('layouts.admin')
@section('title',$title)
@section('content')
<!-- Right Panel -->
<!-- begin content -->


<div class="card">
    <div class="card-header">
    <strong class="card-title">{{$title}}</strong>
    <a href="{{route('addproduction')}}" class="btn btn-primary btn-sm float-right">Tambah Data
            Baru</a>
    </div>
    <div class="card-body">
        <table id="bootstrap-data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Periode</th>
                    <th>Product</th>
                    <th>Jumlah Product</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($data as $key => $value)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$value->periode}}</td>
                    <td>{{$value->product_name}}</td>
                    <td>{{$value->jumlah_product}}</td>
                    <td>
                            <a href="{{route('editproduction',$value->id)}}" class="btn btn-info btn-sm"><i class="fas fa-fw fa-edit"></i></a>
                            
                            <a delete-text="Hapus data pembelian ?"
                             class="btn btn-danger btn-sm" 
                             href="{{ route('deleteproduction',$value->id) }}" 
                             onclick="javascript:swalDelete(this, event);">
                            <i class="fas fa-fw fa-trash-alt"></i> 
                            <form id="deleteMaterial" action="{{route('deleteproduction',$value->id)}}" method="post">
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
