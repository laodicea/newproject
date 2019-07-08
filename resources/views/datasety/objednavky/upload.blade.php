@extends('layouts.portal_app') 
@section('title', Lang::get('m_objednavky.title-obj'))  
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
                <h1 class="page-header">@lang('m_objednavky.h2-obj-insert')</h1>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-9">
            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('m_objednavky.h2-obj-insert')
              </div>
              <div class="panel-body">   
              @include('partials._messages')   
              {!! Form::open(array('route' => 'objednavky.upload', 'files'=> 'true', 'method'=>'POST')) !!}
              {!! csrf_field() !!}
              <div class="form-group">
                {{ Form::label('uploaded_files', Lang::get('m_objednavky.xml-file-from-obj'),['class' => 'form-spacing-top']) }}
                {!! Form::file('uploaded_files[]', ['class'=> 'form-control', 'required' => 'required']) !!}
              </div>
                             
              <button type="submit" class="btn btn-md btn-success" value="send" name="submitbutton" style="margin-top:20px;">@lang('m_objednavky.btn-uplaod')</button>

              <button type="button" class="btn btn-info" style="margin-top: 20px;" onclick="window.location='{{ url('datasety') }}'">{{ __('messages.btn-back')}}</button> 

              {!! Form::close() !!} 
        </div>
      </div>
    </div> 
  </div>
</div>  
</div>
@endsection

  



 
 
          
       
       
         