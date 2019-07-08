@extends('layouts.portal_app')
@section('title', 'Organizačná štruktúra')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
    	    <div class="col-sm-12">
                <h1 class="page-header">@lang('messages.h-org-str')</h1> 
            </div>
        </div>
        <div class="row"> 
        	<div class="col-lg-8">
        		<div class="panel panel-info">
        			<div class="panel-heading">
        				@lang('messages.h-detail-org')
        			</div>
        		<div class="panel-body"> 
	 				@include('partials._messages')  
					<h3 style="text-align: center;">{{ $item->name }}</h3>  
				<dl class="dl-horizontal">
              <dt>{{__('messages.tb-mark-short')}}:</dt>
              <dd>{{ $item->short}}</dd>

              <dt>{{__('messages.tb-naz')}}:</dt>
              <dd>{{ $item->name}}</dd>

              <dt>Skratka pre rozhodnutia:</dt>
              <dd>{{ $item->short_kniha}}</dd>

              <dt>Riadiaci pracovník:</dt>
              <dd>{{ $item->boss}}</dd>

              <dt>Zastupujúci pracovník:</dt>
              <dd>{{ $item->zastupca}}</dd>

              <dt>Nadriadená štruktúra:</dt>
              @foreach($myorgs as $myorg)
              <dd>{{ $myorg}}</dd>
              @endforeach

              <dt>Podriadená štruktúra:</dt>
              <dd>{{ $item->parent}}</dd> 
              <br>
          </dl> 
		</div>
	</div>
</div>
    <div class="col-lg-3">
      <div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-information-item')
              </div>
              <div class="panel-body"> 
            <dl class="dl-vertical">
              <dt>{{__('messages.lb-date-create')}}:</dt>
              <dd>{{ date('j M, Y H:i', strtotime($item->created_at))}}</dd> 
              <dt>{{__('messages.lb-updated_at')}}:</dt>
              <dd>{{ date('j M, Y H:i', strtotime($item->updated_at))}}</dd>
            </dl> 
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
        	   <button type="button" class="btn btn-default btn-sm" onclick="window.location='{{ url('service/department') }}'" ><span class="fa  fa-arrow-left fa-fw"></span> {{ __('messages.btn-back')}}</button>
          </div>  
            @if(auth()->user()->hasRole('administrator'))
            <div class="btn-group">
            	<button type="button" class="btn btn-primary btn-sm" onclick="window.location='{{ URL::route('department.edit', $item->id) }}'" ><span class="fa fa-pencil fa-fw"></span> {{__('messages.btn-edit')}}</button> 
            </div>
            <div class="btn-group">
            	{!! Form::open(['route' => ['department.destroy', $item->id], 'method'=>'DELETE']) !!}
                {{Form::button('Zmazať', array('type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Naozaj si prajete zmazať zvolený odbor? Riadok v db sa neodstrani ale prepise sa len aktivita na false!")'))}} 
             </div>
                {!! Form::close() !!} 
            @endif      
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection
