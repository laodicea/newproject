 @extends('layouts.portal_app') 
 @section('title', Lang::get('m_rezervacie.h-rezervation-rooms')) 
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
 						@lang('m_rezervacie.h-my-reservations') 
 					</div>
 					<div class="panel-body"> 
 						@include('partials._messages') 
 						<table class="table table-hover">
 							<thead>
 								<tr> 
 									<th>@lang('m_rezervacie.lb-name-event')</th>
 									<th>@lang('m_rezervacie.lb-date-start')</th>      
 									<th>@lang('m_rezervacie.lb-date-end')</th> 
 									<th>@lang('m_rezervacie.lb-room')</th> 
 									<th>@lang('messages.lb-created-by')</th>
 									<th>@lang('messages.lb-date-create')</th>
 									<th>@lang('messages.lb-action')</th>  
 								</tr>
 							</thead>
 							<tbody>
 								@foreach($events as $event) 
 								@if($event->start_date > date("Y-m-d H:i:s"))
 								<tr style="background-color: #EEFAFF">
 									@else
 									<tr>
 										@endif 
 										<th>{{ $event->title }}</th>  
 										<th>{{ date('d.m.Y H:i', strtotime($event->start_date)) }}</th>
 										<th>{{ date('d.m.Y H:i', strtotime($event->end_date)) }}</th>    
 										<th>{{ $event->reserve_room->name}}</th> 
 										<th>{{ $event->user->fullname() }}</th>
 										<th>{{ date('d.m.Y', strtotime($event->created_at)) }}</th> 
 										<th width="80">
 											@if($event->start_date > date("Y-m-d H:i:s"))
 											{!! Form::open(['url' => ['rezervacie/event/'.$event->id.'/edit'], 'method'=>'get', 'style'=>'float: left;']) !!} 
 											{{Form::button('<i class="fa  fa-pencil fa-fw"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'title' => 'Editovať'))}} 

 											{!! Form::close() !!}  

 											{!! Form::open(['route' => ['rezervacie.event.destroy', $event->id], 'method'=>'DELETE']) !!} 
 											{{Form::button('<i class="fa fa-trash-o fa-fw"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger	', 'title' => 'Zmazť udalosť', 'onclick' => 'return confirm("Naozaj si prajete zmazať udalosť?")'))}} 
 											@endif
 										{!! Form::close() !!}</th>
 									</tr> 
 									@endforeach
 								</tbody>
 							</table>
 							<div class="text-center">
 								{!! $events->links() !!}
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
 								<div class="col-md-1"><a href="{{ url('rezervacie')}}" class="btn btn-info btn-md">@lang('messages.btn-back')</a></div>
 							</div> 
 						</div>
 					</div>   
 				</div> 
 			</div>  
 		</div>
 	</div>
 	@endsection   

