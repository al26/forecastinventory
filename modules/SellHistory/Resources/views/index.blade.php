@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">{{@$title}}</strong>
                    <a href="{{route('sh.create')}}" class="btn btn-sm btn-primary float-right">Tambah Data Penjualan</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Periode</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Jumlah Penjualan</th>
                            <th>Opsi</th>
                        </thead>
                        <tbody>
                            @if (@$sell_histories)    
                                @foreach ($sell_histories as $key => $sh)
                                    <td>{{$key+=1}}</td>
                                    <td>{{$sh->period}}</td>
                                    <td>{{$sh->product_code}}</td>
                                    <td>{{$sh->product_name}}</td>
                                    <td>{{$sh->amount}}</td>
                                    <td>
                                        <a href="{{route('sh.edit')}}" class="btn btn-sm btn-info"></a>
                                    </td>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
