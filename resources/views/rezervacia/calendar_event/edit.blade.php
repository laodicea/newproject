 @extends('layouts.portal_app') 
 @section('title', Lang::get('m_rezervacie.h-rezervation-rooms')) 
 @section('stylesheets') 
 <link rel="stylesheet" href="{{ URL::asset('css/datetimepicker/bootstrap-datetimepicker.min.css') }}" /> 
 @endsection 
 @section('content') 
 <div id="page-wrapper">
 	<div class="container-fluid">
 		<div class="row">
 			<div class="col-lg-12">
 				<h1 class="page-header">@lang('m_rezervacie.h-rezervation-rooms')</h1>
 			</div>
 		</div>
 		<div class="row">
 			<div class="col-lg-9">
 				<div class="panel panel-info">
 					<div class="panel-heading">
 						@lang('m_rezervacie.h-edit-event')
 					</div>
 					<div class="panel-body"> 
 						@include('partials._messages') 
 						{!! Form::model($event, ['route' => ['rezervacie.udalost.update', $event->id]]) !!}

 						<div class="form-group">
 							{{Form::label('room',Lang::get('m_rezervacie.lb-room')) }}
 							<select id="room" class="form-control" name="room" title="Miestnosť" required> 
 								@foreach($rooms AS  $key=>$room) 
 								@if($event->reserve_room_id == $key)
 								<option value="{{$key}}" selected>{{ $room}}</option> 
 								@else
 								<option value="{{$key}}">{{ $room}}</option> 
 								@endif
 								@endforeach
 							</select>
 						</div>
 						<div class="form-group">
 							{{ Form::label('title', Lang::get('m_rezervacie.lb-name-event')) }}
 							<div class="input-group">
 								{{ Form::text('title', null, ['class' => 'form-control', 'required'=> 'required', 'title' => 'Názov udalosti']) }}
 								<span class="input-group-addon"><span class="fa fa-bell fa-fw"></span></span>
 							</div>
 						</div>
 							<div class="form-group">
 								{{Form::label('start_date', Lang::get('m_rezervacie.lb-date-start')) }} 
 								<div class='input-group date' id='datetimepicker1'>
 									<input type="text" value="{{ $event->getStartDate() }}" id="datetimepicker1" class="form-control" name="start_date" required=""> 
 									<span class="input-group-addon"><span class="fa fa-calendar fa-fw"></span></span>
 								</div>
 							</div>
 							<div class="form-group">
 								{{Form::label('end_date', Lang::get('m_rezervacie.lb-date-end')) }} 
 								<div class='input-group date' id='datetimepicker2'>
 									<input type="text" value="{{ $event->getEndDate() }}" id="datetimepicker2" class="form-control" name="end_date" required=""> 
 									<span class="input-group-addon"><span class="fa fa-calendar fa-fw"></span></span>
 								</div>
 							</div>
 						</div>
 					</div>
 				</div>
 				<div class="col-lg-3">
 					<div class="row"> 
 						<div class="panel panel-info">
 							<div class="panel-heading"> 
 								@lang('messages.h-nav')
 							</div>
 							<div class="panel-body"> 
 								{{ Form::submit(Lang::get('messages.btn-save-changes'), array('class' => 'btn btn-success btn-h1-spacing')) }} 
 								<a href="{{ url('rezervacie/my-events/all')}}" class="btn btn-info btn-md">@lang('messages.btn-back')</a>
 								{!! Form::close() !!} 
 							</div> 
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
            format: 'dd.mm.yyyy HH:ii',
            daysOfWeekDisabled: [0, 6],
            startDate: new Date(),
            weekStart: 1,
            language: 'sk'
        });
    });
    $(function () {
        $('#datetimepicker2').datetimepicker({
            format: 'dd.mm.yyyy HH:ii',
            daysOfWeekDisabled: [0, 6],
            startDate: new Date(),
            weekStart: 1,
            language: 'sk'
        });
    }); 
</script>
@endsection
