@php
    $icon['warning']    = '<i class="fas fa-exclamation-circle text-warning fa-2x mr-3"></i>';
    $icon['success']    = '<i class="fas fa-check-circle text-success fa-2x mr-3"></i>';
    $icon['info']       = '<i class="fas fa-info-circle text-info fa-2x mr-3"></i>';
    $icon['danger']     = '<i class="fas fa-times-circle text-danger fa-2x mr-3"></i>';
@endphp

@if(Session::has('message'))
<div class="row animated zoomin">
    <div class="col-12">
        <div class="alert alert-{{Session::get('type', 'info')}} alert-dismissible fade show" role="alert">
            {{-- <span class="badge badge-{{Session::get('type', 'info')}}"> --}}
            <p class="d-flex align-items-center m-0 p-0">
                {!!$icon[Session::get('type', 'info')]!!}
                <span class=" text-dark font-weight-bolder">{{Session::get('message')}}</span>
            </p>
            {{-- </span>  --}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
@endif