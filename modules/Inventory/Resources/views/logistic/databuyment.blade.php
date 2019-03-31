@extends('layouts.admin')
@section('title','Data Pembelian Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->


<div class="card">
    <div class="card-header">
        <strong class="card-title">Data Pembelian Bahan Baku</strong>
        <a href="{{route('purchasingmaterial')}}" class="btn btn-primary btn-sm float-right">Tambah Data
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
                            <a href="{{route('editpurchase',$value->kode_pembelian)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                            
                            <a class="btn btn-danger btn-sm" href="{{ route('purchasedelete',$value->kode_pembelian) }}" onclick="event.preventDefault();
                            document.getElementById('deleteMaterial').submit();">
                            <i class="menu-icon fas fa-sign-out-alt"></i>
                            
                        </a>

                        <form id="deleteMaterial" action="{{route('purchasedelete',$value->kode_pembelian)}}" method="post">
                            @method('delete')
                            @csrf
                        </form>
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
