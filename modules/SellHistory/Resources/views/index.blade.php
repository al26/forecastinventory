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
                            <tr>
                                <th>#</th>
                                <th>Periode</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Jumlah Penjualan</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (@$sell_histories)    
                                @foreach ($sell_histories as $key => $sh)
                                    <tr>

                                        <td>{{$key+=1}}</td>
                                        <td>{{$sh->period}}</td>
                                        <td>{{$sh->product_code}}</td>
                                        <td>{{$sh->product_name}}</td>
                                        <td>{{$sh->amount}}</td>
                                        <td>
                                            <a href="{{route('sh.edit', ["id" => $sh->id])}}" class="btn btn-sm btn-info"><i class="fas fa-fw fa-edit text-white"></i></a>
                                            <a 
                                                delete-text="Hapus data penjualan ?" 
                                                href="{{route('sh.delete', ["id" => $sh->id])}}" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="javascript:swalDelete(this, event);">
                                                <i class="fas fa-fw fa-trash-alt text-white"></i>
                                                <form method="post" action="{{route('sh.delete', ["id" => $sh->id])}}" >
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop


