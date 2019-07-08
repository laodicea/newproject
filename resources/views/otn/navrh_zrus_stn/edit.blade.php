@extends('layouts.portal_app') 
@section('title', 'OTN - úprava návrhu na zrušenie STN')  
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
                	@lang('otn.h-edit-new-canceled-stn')
              	</div>
              	<div class="panel-body">   
              		@include('partials._messages')
					<h2 class="text-center">Úprava položky v návrhu na zrušenie STN</h2>
    				{!! Form::model($item, ['route' => ['navrh-zrusenia-stn.update', $item->kat_c], 'method' => 'PUT']) !!}
					<div class="form-group"> 
            			{{ Form::label('kat_c', Lang::get('otn.lb-katc')) }}
            			{{ Form::text('kat_c', null, ["class"=> 'form-control', 'readonly' => 'true']) }} 
        			</div>
        			<div class="form-group"> 
	            		{{ Form::label('ozn',Lang::get('messages.lb-ozn'),['class' => 'form-spacing-top']) }}
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
            			{{Form::label('date_vyd', Lang::get('otn.lb-date-approvap-release')) }} <span class="redForm"></span>
            			<div class='input-group date' id='datetimepicker1'>
                		<input type='datepicker' class="form-control" name="date_vyd" data-date-format="yyyy-mm-dd" value="{{ $item->getDateVyd() }}"/>
                		<span class="input-group-addon">
                    	<span class="fa fa-calendar fa-fw"></span>.
                    </span>
            			</div>
        			</div>
        		<div class="form-group">
            {{Form::label('date_nav_zru', Lang::get('otn.lb-date-canceled')) }} <span class="redForm"></span>
            <div class='input-group date' id='datetimepicker2'>
                <input type='datepicker' class="form-control" name="date_nav_zru" data-date-format="yyyy-mm-dd" value="{{ $item->getDateNavZru() }}" />
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
				<div class="col-sm-4">
            	<a href="{{ url('otn/navrh-zrusenia-stn')}}" class="btn btn-primary btn-block"><span class="fa fa-arrow-left fa-fw"></span> {{ __('messages.btn-back')}}</a>
               </div>
    			@if(auth()->user()->hasAnyRole(['otn','administrator'])) 
       			<div class="col-sm-4">
            {{ Form::submit('Uložiť', ['class' => 'btn btn-success btn-block btn-h1-spacing']) }} 
            {!! Form::close() !!}
        </div> 
        <div class="col-sm-4">
            {!! Form::open(['route' => ['navrh-zrusenia-stn.destroy', $item->kat_c], 'method'=>'DELETE']) !!}
            {!! Form::submit(Lang::get('messages.btn-delete'), ['class'=> 'btn btn-danger red-autumn btn-block btn-h1-spacing', 'onclick' => 'return confirm("Naozaj si prajete zmazať položku")']) !!}
            {!! Form::close() !!} 
        </div>
    @endif
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
