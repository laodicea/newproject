@extends('layouts.app')

@section('content')  
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">@lang('messages.login-to-portal')</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <fieldset>
                            <div class="form-group"> 
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="E-mail" type="email">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group"> 
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Heslo">

                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> @lang('messages.remember-me')
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-lg btn-success btn-block">
                                @lang('messages.login') 
                            </button>
                            
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                @lang('messages.forget-pswd')
                            </a>
                        </fieldset>
                    </form>
                    <section>
                            <hr>
                            <h4><small>Podporované prehliadače:</small></h4>
                            <div class="row"> 
                            <article class="col-md-4">
                                <div class="obr"><img src="{{ URL::to('/') }}/img/mozila-icon.png" style="width: 35px;height: 35px"></div>
                                <div class="art-title"><small>Firefox</small></div>
                            </article>
                            <article class="col-md-4">
                                <div class="obr"><img src="{{ URL::to('/') }}/img/edge-icon.jpg" style="width: 35px;height: 35px"></div>
                                <div class="art-title"><small>Edge</small></div>
                            </article>
                            <article class="col-md-4">
                                <div class="obr"><img src="{{ URL::to('/') }}/img/google-icon.png" style="width: 35px;height: 35px"></div>
                                <div class="art-title"><small>Chrome</small></div>
                            </article>
                            </div>
                            <br>   
                            <p><small>Iné prehliadače nemusia správne vykreslovať jednotlivé komponenty v informačnom systéme!</small></p>
                        </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection