@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Error</th>
                        <th scope="col">Absolute Error</th>
                        <th scope="col">Square Error</th>
                        <th scope="col">Error Percentage</th>
                        <th scope="col">Absolute Error Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($moving_avg->raw as $key => $item)
                        <tr>
                            <td>{{$key+=1}}</td>
                            <td>{{$item->error}}</td>
                            <td>{{$item->error_abs}}</td>
                            <td>{{$item->error_square}}</td>
                            <td>{{$item->error_percentage}}</td>
                            <td>{{$item->error_abs_percent}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">MAD</th>
                            <th scope="col">MSE</th>
                            <th scope="col">MAPE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                        {{-- @foreach ($moving_avg['calculation'] as $item) --}}
                            <tr>
                                <td>{{$no+=1}}</td>
                                <td>{{$moving_avg->calculation->mad}}</td>
                                <td>{{$moving_avg->calculation->mse}}</td>
                                <td>{{$moving_avg->calculation->mape}}</td>
                            </tr>
                        {{-- @endforeach --}}
                    </tbody>
            </table>
        </div>
    </div>

@stop
