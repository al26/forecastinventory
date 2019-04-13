@extends('layouts.admin')
@section('title',$title)
@section('content')
<!-- Right Panel -->
<!-- begin content -->


<div class="card">
    <div class="card-header">
    <strong class="card-title">{{$title}}</strong>
    {{-- <a href="{{route('addproduction',['role'=>Auth::user()->getRoleNames()[0]])}}" class="btn btn-primary btn-sm float-right">Tambah Data Baru</a> --}}
    </div>
    <div class="card-body">
        <table id="bootstrap-data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Periode</th>
                    <th>Tahun</th>
                    <th>Produk</th>
                    <th>Jumlah Produk</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($data as $key => $value)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{ucfirst($value->periode)}}</td>
                    <td>{{$value->year}}</td>
                    <td>{{$value->product_name}}</td>
                    <td>{{$value->jumlah_product}}</td>
                <td>{!!$value->status=="berjalan" ? "<span class='badge badge-info'>$value->status</span>":"<span class='badge badge-danger'>$value->status</span>" !!}</td>
                    <td>
                            <a href="{{route('editproduction',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->id])}}" class="btn btn-info btn-sm"><i class="fas fa-fw fa-edit"></i></a>
                            
                            <a delete-text="Hapus data pembelian ?"
                             class="btn btn-danger btn-sm" 
                             href="{{ route('deleteproduction',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->id]) }}" 
                             onclick="javascript:swalDelete(this, event);">
                            <i class="fas fa-fw fa-trash-alt"></i> 
                            <form id="deleteMaterial" action="{{route('deleteproduction',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->id])}}" method="post">
                                    @method('delete')
                                    @csrf
                                </form>
                        </a>
                        <a update-title="Stop Proses Produksi {{$value->product_name}} Periode {{$value->periode}}?" update-text="Produksi yang dihentikan tidak dapat dikembalikan"
                             class="btn btn-danger btn-sm" 
                             href="{{ route('productionstatus',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->id]) }}" 
                             onclick="javascript:swalUpdateStatus(this, event);">
                            <i class="fas fa-fw fa-power-off"></i> 
                            <form id="swalUpdateStatus" action="{{route('productionstatus',['role'=>Auth::user()->getRoleNames()[0],'id'=>$value->id])}}" method="post">
                                    @method('patch')
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
