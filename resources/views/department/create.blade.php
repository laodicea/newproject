@extends('layouts.portal_app') 
@section('title', 'Organizačná štruktúra')
@section('stylesheets')
{!! Html::style('css/select2.min.css') !!}
@endsection 
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
                <h1 class="page-header">@lang('messages.h-org-str')</h1>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-9">
            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-create-org')
              </div>
              <div class="panel-body"> 
              @include('partials._messages') 

              {!! Form::open(array('route' => 'department.store')) !!}

              {!! csrf_field() !!}

              {{ Form::label('short',Lang::get('messages.tb-mark-short')) }}
              {{ Form::text('short', null, array('class' => 'form-control', 'required' => 'requred'))}}

              {{ Form::label('name',Lang::get('messages.lb-title')) }}
              {{ Form::text('name', null, array('class' => 'form-control', 'required' => 'requred')) }} 
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="panel panel-info">
            <div class="panel-heading">
              @lang('messages.h-nav')
            </div>
            <div class="panel-body">
              <div class="btn-group">
              <button type="button" class="btn btn-default btn-sm" onclick="window.location='{{ url('service/department') }}'" ><span class="fa  fa-arrow-left fa-fw"></span>{{ __('messages.btn-back')}}</button> 
              </div>
              <div class="btn-group">
              {{ Form::submit('Vytvoriť', array('class' =>'btn btn-sm btn-success'))}}
              </div>
              {!! Form::close() !!}  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts') 
{!! Html::script('js/select2.min.js') !!}
<script type="text/javascript">
    $('.select2-multi').select2();
</script>
@endsection
