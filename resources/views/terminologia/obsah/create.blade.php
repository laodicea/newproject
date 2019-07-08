 @extends('layouts.portal_app') 
@section('title', Lang::get('m_obsah.title-obsah-create'))  
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
                @lang('m_obsah.h-obsah-create') 
              </div>
              <div class="panel-body"> 
              @include('partials._messages') 
               
              {!! Form::open(array('route' => 'obsahy.store')) !!}

              {!! csrf_field() !!}

              <div class="form-group">
              {{ Form::label('kat_c', lang::get('m_obsah.lb-katc')) }}
              {{ Form::text('kat_c', null, array('class' => 'form-control', 'required' => 'required'))}}
              </div>  
 
              <div class="form-group">
              {{ Form::label('obsah', lang::get('m_obsah.lb-obsah')) }}
              {{ Form::textarea('obsah', null, array('class' => 'form-control', 'required' => 'required'))}}
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
                  <button type="submit" class="btn btn-sm btn-success" value="send" name="submitbutton">@lang('messages.btn-create')</button> 
                {!! Form::close() !!}
              </div>
              <div class="btn-group">
               <button type="button" class="btn btn-sm btn-info" onclick="window.location='{{ route('obsahy.index') }}'">{{ __('messages.btn-back')}}</button> 
              </div>  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
@endsection 

  






 

 
            
 
 
