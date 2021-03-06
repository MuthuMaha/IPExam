@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}
                    <?php 
                //  $aVal = array( '0'=>'payroll_id' );
                // $error = (object) $aVal;

                    if(Session::get('error')){
                    $error=Session::get('error');
                    // print_r($error);
                    // echo $error[0]->payroll_id;
                }
                    ?></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="PAYROLL_ID" class="col-sm-4 col-form-label text-md-right">{{ __('PAYROLL_ID') }}</label>

                            <div class="col-md-6">
                                <input id="PAYROLL_ID" type="text" class="form-control{{ Session::get('error') ? ' is-invalid' : '' }}" name="PAYROLL_ID" value="{{ old('PAYROLL_ID') }}" required autofocus>

                                @if (Session::get('error'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $error[0]->PAYROLL_ID }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="PASS_WORD" class="col-md-4 col-form-label text-md-right">{{ __('PASS_WORD') }}</label>

                            <div class="col-md-6">
                                <input id="PASS_WORD" type="password" class="form-control{{ $errors->has('PASS_WORD') ? ' is-invalid' : '' }}" name="PASS_WORD" required>

                                @if ($errors->has('PASS_WORD'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('PASS_WORD') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
