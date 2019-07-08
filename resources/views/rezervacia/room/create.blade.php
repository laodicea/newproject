@extends('layouts.portal_app') 
@section('title', Lang::get('m_rezervacie.h-rezervation-rooms')) 
@section('content') 
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">@lang('m_rezervacie.h-rezervation-rooms')</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-9">
        <div class="panel panel-info">
          <div class="panel-heading">
            @lang('m_rezervacie.h-create-room')
          </div>
          <div class="panel-body"> 
            @include('partials._messages') 
            {!! Form::open(array('route' => 'room.store')) !!} 
            @csrf
            <div class="form-group">
              {{ Form::label('name', Lang::get('m_rezervacie.lb-name-room')) }}
              {{ Form::text('name', null, ['class' => 'form-control', 'style'=>'margin-bottom:10px', 'required'=> 'required']) }}
            </div>
            <div class="form-group">
              {{ Form::label('color', Lang::get('m_rezervacie.lb-color-event')) }}
              <select id="color" class="form-control" name="color" required> 
                @foreach($colors AS  $key=>$color) 
                <option value="{{$key}}" style="background-color:{{$color}};">{{ $color}}</option> 
                @endforeach
              </select>
            </div>  
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="row"> 
          <div class="panel panel-info">
            <div class="panel-heading"> 
              @lang('messages.h-nav')
            </div>
            <div class="panel-body"> 
              {{ Form::submit(Lang::get('m_rezervacie.btn-add-room'), array('class' => 'btn btn-success')) }} 
              <a href="{{ url('rezervacie')}}" class="btn btn-info">{{ __('messages.btn-back')}}</a> 
              {!! Form::close() !!}
            </div> 
          </div>
        </div>   
      </div> 
    </div>  
  </div>
</div>  
@endsection   

