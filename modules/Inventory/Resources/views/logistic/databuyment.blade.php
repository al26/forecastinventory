@extends('layouts.admin')
@section('title','Data Pembelian Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->


<div class="card">
    <div class="card-header">
        <strong class="card-title">Data Pembelian Bahan Baku</strong>
        <a href="{{route('purchasingmaterial',['role'=>Auth::user()->getRoleNames()[0]])}}" class="btn btn-primary btn-sm float-right">Tambah Data
            Baru</a>
    </div>
    <div class="card-body">
        <table id="bootstrap-data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
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
                    <td>Rp{{number_format($value->Nominal,2,",",".")}}</td>
                    <td>
                            <a href="{{route('editpurchase',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->kode_pembelian])}}" class="btn btn-info btn-sm"><i class="fas fa-fw fa-edit"></i></a>
                            
                            <a delete-text="Hapus data pembelian ?"
                             class="btn btn-danger btn-sm" 
                             href="{{ route('purchasedelete',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->kode_pembelian]) }}" 
                             onclick="javascript:swalDelete(this, event);">
                            <i class="fas fa-fw fa-trash-alt"></i> 
                            <form id="deleteMaterial" action="{{route('purchasedelete',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->kode_pembelian])}}" method="post">
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
