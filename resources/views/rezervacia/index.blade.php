@extends('layouts.portal_app') 
@section('title', Lang::get('m_rezervacie.h-rezervation-rooms')) 
@section('stylesheets')  
<link rel="stylesheet" href="{{ URL::asset('css/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="{{ URL::asset('css/fullcalendar/fullcalendar.print.min.css') }}" rel="stylesheet" media="print"/> 
<link rel="stylesheet" href="{{ URL::asset('css/datetimepicker/bootstrap-datetimepicker.min.css') }}" />

<style>
  .others {
    color:black
}
</style>
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
                @lang('m_rezervacie.h-callendar-reservation')
                @isset($rooms)
                  @foreach($rooms AS  $key=>$room) 
                    @if($idselect == $key)
                      - {{ $room }}
                    @endif
                  @endforeach
                @endisset 
              </div>
              <div class="panel-body">  
              @if(isset($calendar)) 
                <div id="calendar"> 
                  {!! $calendar->calendar() !!} 
                </div>
              @else 
                <img src="{!! asset('img/calendar_sup.png') !!}" style="max-width:100%;max-height:100%;">
              @endif  
            </div>
          </div>
        </div>
      <div class="col-lg-3">
      <div class="row"> 
          <div class="panel panel-info">
            <div class="panel-heading">
              @lang('m_rezervacie.h-rooms-to-reserve')
            </div>
            <div class="panel-body">
              @if(isset($items))
                @foreach($items as $item) 
                  <a href="{{ route('rezervacie.show', $item->id) }}" title="{{ $item->note }}" class="rooms">{{ $item->name }}</a> 
                  <br>
                @endforeach
              @endif  
            </div> 
          </div>
        </div> 
      <div class="row">
      <div class="panel panel-info">
        <div class="panel-heading">
          @lang('m_rezervacie.h-crate-reservation')
        </div>
        <div class="panel-body">
        @include('partials._messages')  
          @if(isset($item))
            {!! Form::open(['route' => ['rezervacie.udalost.store', $item->id]]) !!}
          @endif
          <div class="form-group">
            {{Form::label('room','Miestnosť') }} 
            <select id="room" class="form-control" name="room" > 
              @isset($rooms)
                @foreach($rooms AS  $key=>$room) 
                  @if($idselect == $key)
                    <option value="{{$key}}" selected="" class="others">{{ $room}}</option> 
                  @else
                    <option value="{{$key}}" class="others">{{ $room}}</option> 
                  @endif 
                @endforeach
              @endisset
            </select>
          </div> 
          <div class="form-group">
            {{ Form::label('title', Lang::get('m_rezervacie.lb-name-event')) }}
            {{ Form::text('title', null, ['class' => 'form-control', 'style'=>'margin-bottom:10px', 'required'=> 'required']) }}
          </div> 
          <div class="form-group">
            {{Form::label('start_date', Lang::get('m_rezervacie.lb-date-start')) }}  
            <div class='input-group date' id='datetimepicker1'>
              <input type="text" value="" id="datetimepicker1" class="form-control" name="start_date" required="" data-date-format="d.m.Y H:i"> 
                <span class="input-group-addon"><span class="fa fa-calendar fa-fw"></span></span>
            </div>
          </div>
          <div class="form-group">
            {{Form::label('end_date', Lang::get('m_rezervacie.lb-date-end')) }} 
            <div class='input-group date' id='datetimepicker2'>
              <input type="text" value="" id="datetimepicker2" class="form-control" name="end_date" required="" data-date-format="d.m.Y H:i"> 
                <span class="input-group-addon"><span class="fa fa-calendar fa-fw"></span></span>
            </div> 
          </div>
          <div class="form-group">
            {{ Form::submit(Lang::get('m_rezervacie.btn-create-event'), array('class' => 'btn btn-success btn-block')) }} 
            {!! Form::close() !!} 
          </div>
        </div>
      </div> 
    </div>
    <div class="row">
      <div class="panel panel-info">
        <div class="panel-heading">
          @lang('m_rezervacie.h-edit-reservation')
        </div>
        <div class="panel-body">
               <a href="{{ route('rezervacie.udalost.all') }}" class="btn btn-primary btn-block" title="Zobraziť moje rezervácie">@lang('m_rezervacie.btn-show-my-rezervation')</a>  
               @if(auth()->user()->hasRole('administrator'))
                <a href="{{ route('room.create') }}" class="btn btn-primary btn-block" title="Vytvoriť miestnosť">@lang('m_rezervacie.btn-add-room')</a>
                <a href="{{ route('room.index') }}" class="btn btn-primary btn-block" title="Všetky miestnosti">@lang('m_rezervacie.btn-all-rooms')</a>
               @endif 
        </div> 
      </div>
    </div>
  </div> 
      </div>  
    </div>
  </div>  
@endsection  
@section('scripts') 
<script src="{{ URL::asset('js/fullcalendar/moment.min.js') }}"></script>  
<script src="{{ asset('js/fullcalendar/jquery-ui.min.js')}}"></script>
<script src="{{ URL::asset('js/fullcalendar/fullcalendar.min.js') }}"></script>  

 @if(isset($calendar))
{!! $calendar->script() !!}
@endif  
<script src="{{ URL::asset('js/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>   
<script src="{{ URL::asset('js/datetimepicker/locales/bootstrap-datetimepicker.sk.js') }}" charset="UTF-8"></script> 
<script type="text/javascript">
   //$('#datetimepicker1').datetimepicker('setStartDate', new Date());
   //$('#datetimepicker2').datetimepicker('setStartDate', new Date()); 
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

