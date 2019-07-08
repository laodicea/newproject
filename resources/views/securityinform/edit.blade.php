edit.blade.php
@extends('layouts.portal_app') 
@section('title', 'Úprava oznamu informačnej bezpečnosti') 
@section('stylesheets') 
  <style type="text/css">
    ul {
      list-style-type: none;
    }
    .context-menu {\
      cursor: context-menu;
    }
  </style>
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
                @lang('messages.h-inform-sec-update')
              </div>
              <div class="panel-body"> 
              @include('partials._messages') 
              {!! Form::model($item, ['route' => ['security-inform.update', $item->slug],'files'=> 'true']) !!}

              {!! csrf_field() !!}
               <input type="hidden" name="_method" value="PUT">
              <div class="form-group">
              {{ Form::label('title',Lang::get('messages.lb-title')) }}
              {{ Form::text('title', null, array('class' => 'form-control', 'required' => 'requred'))}}
              </div>
              <div class="form-group">
              {{ Form::label('description',Lang::get('messages.lb-text')) }}
              {{ Form::textarea('description', null, array('class' => 'form-control', 'required' => 'requred')) }}
              </div> 
              <div class="form-group">
              {{ Form::label('securitycategories_id',Lang::get('messages.lb-category')) }}
              {{ Form::select('securitycategories_id', $category, null, ['class'=>'form-control']) }} 
              </div> 
              <div class="form-group">
              {{ Form::label('files',Lang::get('messages.lb-uploaded-files')) }} 
               {{-- Files field --}}
                              @if( isset($files))
                                <ul class="list-group" id="myList">
                                  @foreach($files as $file)
                                  <li id="{{ $file->id }}list"><span class="fa fa-file fa-fw"></span>{{ $file->name }} <span onclick="(removeli('{{$file->id}}list'))" class="fa fa-times fa-fw context-menu"></span><input type="hidden" name="listFiles[]" value="{{ $file->id }}"></li>
                                  @endforeach     
                                </ul>
                              @endif
                            <div class="form-group add-files">
                            {!! Form::file('uploaded_files[]', ['class'=> 'form-control', 'multiple' => 'multiple', 'value'=> 'textik.txt'] ) !!}
                            </div>  
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
                @endif{!! Form::close() !!} 
              </div>
              <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm" onclick="window.location='{{ Route('security-inform.index') }}'">{{ __('messages.btn-back')}}</button>
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

  


