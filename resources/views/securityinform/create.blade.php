 @extends('layouts.portal_app') 
@section('title', 'Vytvorenie položky v IB')  
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
                @lang('messages.h-inform-sec-crate') 
              </div>
              <div class="panel-body"> 
              @include('partials._messages') 
               
              {!! Form::open(array('route' => 'security-inform.store', 'files'=> 'true')) !!}

              {!! csrf_field() !!}
 
              <div class="form-group">
              {{ Form::label('title','Názov') }}
              {{ Form::text('title', null, array('class' => 'form-control', 'required' => 'required'))}}
              </div>
              <div class="form-group">
              {{ Form::label('description','Text') }}
              {{ Form::textarea('description', null, array('class' => 'form-control', 'required' => 'required'))}}
              </div> 
              <div class="form-group">
               {{ Form::label('securitycategories_id','Kategória',['class' => 'form-spacing-top']) }}
                {{ Form::select('securitycategories_id', $category, null, ['class'=>'form-control']) }}
              </div>  
              <div class="form-group">
                {{ Form::label('uploaded_files','Prílohy' ,['class' => 'form-spacing-top']) }}
                {!! Form::file('uploaded_files[]', ['class'=> 'form-control', 'multiple' => 'multiple']) !!}
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
                  <button type="submit" class="btn btn-sm btn-success" value="send" name="submitbutton">@lang('messages.btn-create')</button>
                @endif
                {!! Form::close() !!}
              </div>
              <div class="btn-group">
               <button type="button" class="btn btn-sm btn-info" onclick="window.location='{{ route('security-inform.index') }}'">{{ __('messages.btn-back')}}</button> 
              </div>  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
@endsection 

  






 

 
            
 
 
