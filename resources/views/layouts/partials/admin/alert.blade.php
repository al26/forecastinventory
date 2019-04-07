@if(Session::has('message'))
<div class="row animated zoomin">
    <div class="col-12">
        <div class="alert alert-{{Session::get('type', 'info')}} alert-dismissible fade show" role="alert">
            <span class="badge badge-pill badge-success">{{Session::get('type', 'info')}}</span> {{Session::get('message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
@endif