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
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#sh-delete').on('click', function(e) {
                let uri = $(this).attr('href');
                console.log(uri);
                e.preventDefault();
                swal({
                    title: 'Hapus data penjualan?',
                    text: "Data yang telah dihapus tidak dapat dikembalikan.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3490dc',
                    cancelButtonColor: '#e3342f',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = uri; 
                    }
                })
            })
        })
    </script> --}}
    <script>
        $(document).ready(function() {

        })
    </script>
@endsection

