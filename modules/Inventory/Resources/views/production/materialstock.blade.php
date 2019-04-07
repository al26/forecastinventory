@extends('layouts.admin')
@section('title','Data Persediaan Bahan Baku')
@section('content')
<!-- Right Panel -->
<!-- begin content -->



<div class="card">
    <div class="card-header">
        <strong class="card-title">Data Persediaan Bahan Baku</strong>
        {{-- <a href="#" class="btn btn-primary btn-sm float-right">Tambah Data Baru</a> --}}
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
                    <td>{{$value->material_name}}</td>
                    <td>{{$value->material_type}}</td>
                    <td>{{$value->material_stock}}</td>
                    <td>
                        <a get-title="Kurangi Bahanbaku {{$value->material_name}}?" get-text="Bahanbaku yang manipulasi dapat menyebabkan pencatatan tidak valid dan tidak dapat dikembalikan"
                            class="btn btn-danger btn-sm" 
                            href="{{ route('reducematerial',$value->material_code) }}" 
                            onclick="javascript:swalGetdata(this, event);">
                           <i class="fas fa-fw fa-arrow-down"></i> 
                           <form id="swalGetdata" action="{{route('reducematerial',$value->material_code)}}" method="get">
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
