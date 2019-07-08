@extends('layouts.portal_app') 
@section('title', 'Úprava kategórie oznamu informačnej bezpečnosti') 
@section('stylesheets')  
@endsection
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
                <h1 class="page-header">@lang('messages.h-inform-sec')</h1>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-9">
            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-inform-sec-category-edit')
              </div>
              <div class="panel-body"> 
              @include('partials._messages') 
              {!! Form::model($item, ['route' => ['security-category.update', $item->id]]) !!}

              {!! csrf_field() !!}
               <input type="hidden" name="_method" value="PUT">
              <div class="form-group">
              {{ Form::label('name',Lang::get('messages.tb-naz')) }}
              {{ Form::text('name', null, array('class' => 'form-control', 'required' => 'requred'))}}
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
                @if (auth()->user()->hasAnyRole(['security_inform','administrator']))
                  {{ Form::submit(Lang::get('messages.btn-save-changes'), array('class' =>'btn btn-sm btn-success'))}}
                @endif
                {!! Form::close() !!} 
              </div>
              <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm" onclick="window.location='{{ Route('security-category.index') }}'">{{ __('messages.btn-back')}}</button>
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

  


