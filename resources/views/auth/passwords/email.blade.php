@extends('layouts.app')


@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">@lang('messages.reset-password')</h3>
                    </div>
                    <div class="panel-body">  
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">@lang('messages.lb-email')</label>

                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif 
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                @lang('messages.reset-password-to-mail')
                            </button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
