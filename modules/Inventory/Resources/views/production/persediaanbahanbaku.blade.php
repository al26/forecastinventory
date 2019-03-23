@extends('layouts.admin')
@section('title','Data Persediaan Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
        <strong class="card-title">Data Persediaan Bahan Baku</strong>
        <a href="#" class="btn btn-primary btn-sm float-right">Tambah Data Baru</a>
    </div>
    <div class="card-body">
        <table id="bootstrap-data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bahan Baku</th>
                    <th>Jenis Bahan Baku</th>
                    <th>Jumlah Stock</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($data as $key => $value)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$value->nama_bahanbaku}}</td>
                    <td>{{$value->jenis_bahanbaku}}</td>
                    <td>{{$value->jumlah_stock}}</td>
                    <td>
                        <a href="" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i></a>
                        <a href="" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i></a>
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
