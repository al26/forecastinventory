@extends('layouts.admin')
@section('title','Data Pembelian Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->


<div class="card">
    <div class="card-header">
        <strong class="card-title">Data Pembelian Bahan Baku</strong>
        <a href="{{route('pembelianbahanbaku')}}" class="btn btn-primary btn-sm float-right">Tambah Data
            Baru</a>
    </div>
    <div class="card-body">
        <table id="bootstrap-data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Beli</th>
                    <th>Bahan Baku</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($data as $key => $value)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{date('d-M-y',strtotime($value->tanggal_beli))}}</td>
                    <td>{{$value->bahan_baku}}</td>
                    <td>{{$value->Jumlah}}</td>
                    <td>{{$value->Nominal}}</td>
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