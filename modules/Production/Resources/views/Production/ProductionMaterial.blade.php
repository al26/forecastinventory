

@extends('layouts.admin')
@section('title',$title)
@section('content')
<!-- Right Panel -->
<!-- begin content -->


<div class="card">
    <div class="card-header">
    <strong class="card-title">{{$title}}</strong>
    {{-- <a href="{{route('addproduction')}}" class="btn btn-primary btn-sm float-right">Tambah Data
            Baru</a> --}}
    </div>
    <div class="card-body">
        <table id="bootstrap-data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Periode Produksi</th>
                    <th>Nama Produk</th>
                    <th>Jumlah Produksi</th>
                    <th>Nama Material</th>
                    <th>Kebutuhan Produk/Material</th>
                    <th>Kebutuhan Total Material</th>
                    <th>Stock Material</th>
                    <th>Unit</th>
                    <th>Status</th>
                    
                </tr>
            </thead>
            <tbody>

                @foreach ($data as $key => $value)
                @php
                    $materialneed_total = floatval($value->kebutuhan_material)*floatval($value->jumlah_production);
                @endphp
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$value->periode_production}}</td>
                    <td>{{$value->product_name}}</td>
                    <td>{{$value->jumlah_production}}</td>
                    <td>{{$value->material_name}}</td>
                    <td>{{$value->kebutuhan_material}}</td>
                    <td>{{$materialneed_total}}</td>
                    <td>{{$value->stock_material}}</td>
                    <td>{{$value->unit}}</td>
                    {{-- </span> --}}
                    {{-- <span class='badge bagde-sm   --}}
                    
                <td>
                    @if ($value->stock_material < $materialneed_total)
                    <span class="badge badge-danger">Restock</span>
                    @else
                    <span class="badge badge-info">Cukup</span>
                    @endif
                      
                </td>
                
                
                {{-- <td>
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

                        
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- end content -->
<!-- Right Panel -->
@stop
