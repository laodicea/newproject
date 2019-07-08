edit.blade.php
@extends('layouts.portal_app') 
@section('title', Lang::get('m_obsah.title-obsah-edit')) 
@section('stylesheets') 
  <style type="text/css">
    ul {
      list-style-type: none;
    }
    .context-menu { 
      cursor: context-menu;
    }
  </style>
@endsection
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
                <h1 class="page-header">@lang('m_obsah.h-obsah')</h1>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-9">
            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('m_obsah.h-obsah-edit')
              </div>
              <div class="panel-body"> 
              @include('partials._messages') 
              {!! Form::model($item, ['route' => ['obsahy.update', $item->kat_c]]) !!}

              {!! csrf_field() !!}
               <input type="hidden" name="_method" value="PUT">
              <div class="form-group">
              {{ Form::label('kat_c',Lang::get('m_obsah.lb-katc')) }}
              {{ Form::text('kat_c', null, array('class' => 'form-control', 'readonly' => 'readonly', 'pattern' => '[0-9]' ))}}
              </div>
              <div class="form-group">
              {{ Form::label('obsah',Lang::get('m_obsah.lb-obsah')) }}
              {{ Form::textarea('obsah', null, array('class' => 'form-control', 'required' => 'requred')) }}
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
                  {{ Form::submit(Lang::get('messages.btn-save-changes'), array('class' =>'btn btn-sm btn-success'))}}
             
              </div>
              <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm" onclick="window.location='{{ Route('obsahy.index') }}'">{{ __('messages.btn-back')}}</button>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection 
@section('scripts')  
<script>
  function removeli($nm){
var list = document.getElementById($nm); 
list.parentElement.removeChild(list); 
 
}
</script>
@endsection

  


