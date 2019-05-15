@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><strong>Panduan Program</strong></h4>
                    <ul class="list-group list-group-flush">
                        @if (isset($guide))
                            @foreach ($guide as $g)
                                <li class="list-group-item px-0">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{$g['menu']}}</h5>
                                    </div>
                                    <p class="mb-1 text-dark">{!! $g['desc'] !!}</p>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection