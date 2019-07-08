@extends('layouts.portal_app') 
@section('title', 'Organizačná štruktúra') 
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
                @lang('messages.h-edit-department')
              </div>
              <div class="panel-body"> 
              @include('partials._messages') 
              {!! Form::model($item, ['route' => ['department.update', $item->id]]) !!}

              {!! csrf_field() !!}
              <div class="form-group">
              {{ Form::label('short',Lang::get('messages.tb-mark-short')) }}
              {{ Form::text('short', null, array('class' => 'form-control', 'required' => 'requred'))}}
              </div>
              <div class="form-group">
              {{ Form::label('name',Lang::get('messages.tb-naz')) }}
              {{ Form::text('name', null, array('class' => 'form-control', 'required' => 'requred')) }}
              </div> 
              <div class="form-group">
              {{ Form::label('boss','Riadiaci pracovník oddelenia' ,['class' => 'form-spacing-top', 'required' => 'required']) }}
              {{ Form::select('boss', $bossusers, null, ['class'=>'form-control']) }} 
              </div> 
              <!--
              <div class="form-group">
              {{ Form::label('zastupca','Zastupujúci pracovník oddelenia' ,['class' => 'form-spacing-top']) }}
              <select class="form-control" name="zastupca">
              @foreach($users as $key => $user)
              @if($key == $item->zastupca)
              <option value='{{ $key }}' selected="">{{ $user }}</option>
              @else
              <option value='{{ $key }}'>{{ $user }}</option>
              @endif
              @endforeach
              </select> 
              </div> -->  
            <div class="form-group">
              {{ Form::label('parent','Nadriadená štruktúra' ,['class' => 'form-spacing-top']) }}
               {{ Form::select('parent', $orgs, null, ['class'=>'form-control']) }}
            </div> 
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
              {{ Form::submit(Lang::get('messages.btn-save-changes'), array('class' =>'btn btn-sm btn-success'))}}{!! Form::close() !!} 
              </div>
              <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm" onclick="window.location='{{ url('service/department') }}'">{{ __('messages.btn-back')}}</button>
            </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection 

  


