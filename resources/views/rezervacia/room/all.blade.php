 @extends('layouts.portal_app') 
 @section('title', Lang::get('m_rezervacie.h-rezervation-rooms')) 
 @section('stylesheets')  
 <style type="text/css">
 #circle { 
 	width: 20px; 
 	height: 20px; 
 	border-radius: 6px;
 	background-color: red;
 	margin-top: 4px;
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
						@lang('m_rezervacie.h-all-rooms')
					</div>
					<div class="panel-body"> 
						@include('partials._messages') 
						<table class="table table-hover">
							<thead>
								<tr> 
									<th>@lang('m_rezervacie.lb-name-room')</th>
									<th>@lang('m_rezervacie.lb-color-room')</th>
									<th>@lang('messages.lb-created-by')</th>  
									<th>@lang('messages.lb-action')</th>  
								</tr>
							</thead>
							<tbody>
								@foreach($rooms as $room) 
								<tr>
									<th>{{ $room->name }}</th> 
									<th><div id="circle" style="background-color: {{ $room->color->color }}"></div></th>
									<th>{{ date('d.m.Y H:i', strtotime($room->created_at)) }}</th>  
									<th>
										{!! Form::open(['url' => ['rezervacie/room/'.$room->id.'/edit'], 'method'=>'get', 'style'=>'float: left;']) !!} 
										{{Form::button('<i class="fa fa-pencil fa-fw"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'title' => 'Editovať'))}} 

										{!! Form::close() !!} 
										{!! Form::open(['route' => ['room.destroy', $room->id], 'method'=>'DELETE']) !!} 
										{{Form::button('<i class="fa fa-trash fa-fw"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'title' => 'Zmazť miestnosť', 'onclick' => 'return confirm("Naozaj si prajete zmazať miestnosť? Tento krok može mať za následok stratu rezervácií v danom kalendári. Odporúčaním je kontaktovat administrátora portálu!")'))}}  
									{!! Form::close() !!}</th>
								</tr> 
								@endforeach
							</tbody>
						</table>
						<div class="text-center">
							{!! $rooms->links() !!}
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
							<a href="{{ route('room.create') }}" class="btn btn-primary" title="Vytvoriť miestnosť">@lang('m_rezervacie.btn-create-room')</a>
							<a href="{{ url('rezervacie')}}" class="btn btn-info">@lang('messages.btn-back')</a> 
						</div> 
					</div>
				</div>   
			</div> 
		</div>  
	</div>
</div>  
@endsection   

