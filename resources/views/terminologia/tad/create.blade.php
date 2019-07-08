@extends('layouts.portal_app') 
@section('title', 'Vloženie TaD')  
@section('pageName', 'Vloženie TaD')
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">@lang('m_tad.h-tad')</h1>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-9">
            <div class="panel panel-info">
              	<div class="panel-heading">
                	@lang('m_tad.h-tad-create')
              	</div>
              	<div class="panel-body">   
              		@include('partials._messages')  
			{!! Form::open(array('route' => 'tad.store')) !!}
            
            {!! csrf_field() !!}
            <div class="form-group"> 
            {{ Form::label('kat_c',Lang::get('m_tad.tb-kat_c')) }}
            {{ Form::text('kat_c', null, array('class' => 'form-control', 'required' => 'requred', 'pattern' => '[0-9]+' )) }}
			</div>
			<div class="form-group"> 
            {{ Form::label('skterm',Lang::get('m_tad.tb-skterm')) }}
            {{ Form::text('skterm', null, array('class' => 'form-control', 'required' => 'requred', 'maxlength' => '255')) }}
			</div>
			<div class="form-group"> 
            {{ Form::label('skdef',Lang::get('m_tad.tb-skdef')) }}
            {{ Form::textarea('skdef', null, array('class' => 'form-control')) }}
			</div>
			<div class="form-group"> 
            {{ Form::label('sknote',Lang::get('m_tad.tb-sknote')) }}
            {{ Form::textarea('sknote', null, array('class' => 'form-control')) }}
			</div>
			<div class="form-group"> 
            {{ Form::label('enterm',Lang::get('m_tad.tb-enterm')) }}
            {{ Form::text('enterm', null, array('class' => 'form-control', 'maxlength' => '255')) }}
			</div>
			<div class="form-group"> 
            {{ Form::label('endef',Lang::get('m_tad.tb-endef')) }}
            {{ Form::textarea('endef', null, array('class' => 'form-control')) }}
			</div>
			<div class="form-group"> 
            {{ Form::label('ennote',Lang::get('m_tad.tb-ennote')) }}
            {{ Form::textarea('ennote', null, array('class' => 'form-control')) }}
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
                    <button type="button" class="btn btn-info" style="margin-top: 20px;" onclick="window.location='{{ url('terminologia/tad') }}'"><i class="fa fa-arrow-left fa-fw"></i> {{ __('messages.btn-back')}}</button> 
                </div>
                <div class="btn-group">
                    {{ Form::submit(Lang::get('m_tad.create'), array('class' =>'btn btn-md btn-success', 'style' => 'margin-top:20px;'))}}
                    
                    {!! Form::close() !!} 
                </div> 
	        </div>
	      </div>
	    </div> 
    </div>
</div>   
</div>                                  
@endsection 



