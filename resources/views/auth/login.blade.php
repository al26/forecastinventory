@extends('layouts.app') 
@section('content')
<div class="bg-overlay">
    <div class="bg-pattern"></div>
</div>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <h2 class="text-center m-3 text-white font-weight-bolder">Forcastinventory</h2>
            <div class="card">
                <div class="card-body bg-white p-3">
                    <h3 class="text-center m-3 font-weight-bolder"><i class="fas fa-door-open text-primary mx-2"></i>Silahkan Masuk</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="username">{{ __('Username') }}</label>
                            <input id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}"
                                required autofocus> 
                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span> 
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                    required> 
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span> 
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old( 'remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Ingat Saya') }}
                                </label>
                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link float-right py-0" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a> 
                                @endif --}}
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Masuk') }}
                            </button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <small class="text-primary font-weight-light">&copy;{{date('Y')}} Forcastinventory | All Rights Reserved.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection