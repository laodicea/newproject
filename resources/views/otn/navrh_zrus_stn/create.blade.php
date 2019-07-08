@extends('layouts.portal_app') 
@section('title', 'Návrh zrušenia STN')
 @section('stylesheets') 
 <link rel="stylesheet" href="{{ URL::asset('css/datetimepicker/bootstrap-datetimepicker.min.css') }}" /> 
 @endsection   
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">@lang('otn.h-navrhy-na-zrusenie-stn')</h1>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-9">
            <div class="panel panel-info">
              	<div class="panel-heading">
                	@lang('otn.h-navrhy-na-zrusenie-stn')
              	</div>
              	<div class="panel-body">   
              		@include('partials._messages')  
               		{!! Form::open(array('route' => 'navrh-zrusenia-stn.store')) !!}
 
        			<div class="form-group"> 
			            {{ Form::label('kat_c', Lang::get('otn.lb-katc')) }}
			            {{ Form::text('kat_c', null, ["class"=> 'form-control']) }} 
        			</div>
			        <div class="form-group"> 
			            {{ Form::label('ozn', Lang::get('messages.lb-ozn'),['class' => 'form-spacing-top']) }}
			            {{ Form::text('ozn', null, ["class"=> 'form-control']) }}  
			        </div>
			        <div class="form-group"> 
			            {{ Form::label('nazov', Lang::get('messages.lb-nazov')) }}
			            {{ Form::text('nazov', null, ["class"=> 'form-control']) }} 
			        </div>
			        <div class="form-group"> 
			            {{ Form::label('zodp_zam', Lang::get('messages.lb-zodp-employee')) }} 
			            {{ Form::text('zodp_zam', null, ["class"=> 'form-control']) }}  
			        </div>
			        <div class="form-group">
			            {{Form::label('date_vyd',Lang::get('otn.lb-date-approvap-release')) }}
			            <div class='input-group date' id='datetimepicker1'>
			                <input type='text' class="form-control" name="date_vyd" data-date-format="dd.mm.yyyy" />
			                <span class="input-group-addon">
			                    <span class="fa fa-calendar fa-fw"></span>
			                </span>
			            </div>
			        </div>
			        <div class="form-group">
			            {{Form::label('date_nav_zru',Lang::get('otn.lb-date-canceled')) }}
			            <div class='input-group date' id='datetimepicker2'>
			                <input type='text' class="form-control" name="date_nav_zru" data-date-format="dd.mm.yyyy" />
			                <span class="input-group-addon">
			                    <span class="fa fa-calendar fa-fw"></span>
			                </span>
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
				
		            {{ Form::submit('Uložiť', ['class' => 'btn btn-success']) }} 
		        
		            {!! Form::close() !!} 

	        	<button type="button" class="btn btn-primary" onclick="window.location='{{ url('otn/navrh-zrusenia-stn')}}'"><span class="fa fa-arrow-left fa-fw"></span> {{ __('messages.btn-back')}}</button> 
	         
	        </div>
	      </div>
	    </div> 
    </div>
  </div> 
</div> 
    
@endsection
@section('scripts')
<script src="{{ URL::asset('js/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ URL::asset('js/datetimepicker/locales/bootstrap-datetimepicker.sk.js') }}" charset="UTF-8"></script> 
<script type="text/javascript"> 
  $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'dd.mm.yyyy',
                minView: 2,
                weekStart: 1,
                language: 'sk'
            });
        });
    $(function () {
        $('#datetimepicker2').datetimepicker({  
            format: 'dd.mm.yyyy',
            minView: 2,
            weekStart: 1,
            language: 'sk'
        });
    }); 
</script>
@endsection
