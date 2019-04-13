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
                                <th class="no-sort">#</th>
                                <th class="no-sort">Periode</th>
                                <th class="no-sort">Tahun</th>
                                <th class="no-sort">Kode Produk</th>
                                <th class="no-sort">Nama Produk</th>
                                <th class="">Jumlah Penjualan</th>
                                <th class="no-sort">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (@$sell_histories)
                                @php
                                    $no = 1;
                                @endphp    
                                @foreach ($sell_histories as $key => $sh)
                                    <tr>
                                        <td>{{$no}}</td>
                                        <td>{{ucfirst($sh->period)}}</td>
                                        <td>{{$sh->year}}</td>
                                        <td>{{$sh->product_code}}</td>
                                        <td>{{$sh->product_name}}</td>
                                        <td>{{$sh->amount}}</td>
                                        <td>
                                            <a href="{{route('sh.edit', ["id" => $sh->id])}}" class="btn btn-sm btn-info {{$sh->forecasted ? 'disabled' : ''}}" {{$sh->forecasted ? 'disabled' : ''}}><i class="fas fa-fw fa-edit text-white"></i></a>
                                            {{-- <a 
                                                delete-text="Hapus data penjualan ?" 
                                                href="{{route('sh.delete', ["id" => $sh->id])}}" 
                                                class="btn btn-sm btn-danger {{$sh->forecasted ? 'disabled' : ''}}" {{$sh->forecasted ? 'disabled' : ''}} 
                                                onclick="javascript:swalDelete(this, event);">
                                                <i class="fas fa-fw fa-trash-alt text-white"></i>
                                                <form method="post" action="{{route('sh.delete', ["id" => $sh->id])}}" >
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </a> --}}
                                        </td>
                                    </tr>
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop


