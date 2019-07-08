@extends('layouts.portal_app')
@section('title', Lang::get('m_user.title-user-show'))
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
    	    <div class="col-sm-12">
                <h1 class="page-header">@lang('m_user.h-user')</h1> 
            </div>
        </div>
        <div class="row"> 
        	<div class="col-lg-9">
        		<div class="panel panel-info">
        			<div class="panel-heading">
        				@lang('m_user.h-user-show')
        			</div>
        		<div class="panel-body"> 
	 				@include('partials._messages')  
					<h3 style="text-align: center;">{{ $item->fullname() }}</h3>  
				<dl class="dl-vertical">
          <dt></dt>
          <dd><strong>{{__('m_user.lb-department')}}: </strong>{{ $item->department->name }}</dd>
       
          <dt></dt>
          <dd><strong>{{__('messages.lb-email')}}: </strong>{{ $item->email }}</dd>

          <dt></dt>
          <dd><strong>{{__('messages.lb-titul')}}: </strong>{{ $item->degree }}</dd>
 
          <dt></dt>
          <dd><strong>{{__('messages.lb-phone')}}: </strong>{{ $item->phone }}</dd>

          <dt></dt>
          <dd><strong>{{__('messages.lb-room')}}: </strong>{{ $item->room }}</dd>
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
              <dd>{{ $item->getCreatedAt() }}</dd> 
              <dt>{{__('messages.lb-updated_at')}}:</dt>
              <dd>{{ $item->getUpdatedAt() }}</dd> 
            </dl> 
          </div>
        </div>
        <div class="panel panel-info">
               <div class="panel-heading">
                  @lang('messages.h-nav')
              </div>
              <div class="panel-body"> 
                <div class="btn-group">
                   <button type="button" class="btn btn-default btn-sm" onclick="window.location='{{ URL::previous() }}'" ><span class="fa  fa-arrow-left fa-fw"></span> {{ __('messages.btn-back')}}</button>
                </div>  
                  @if (auth()->user()->hasAnyRole(['user_manager','administrator']))
                  <div class="btn-group"> 
                    <a href="{{ route('user.edit', $item->id) }}" class="btn btn-primary btn-sm">{{__('messages.btn-edit')}}</a> 
                  </div>
                  <div class="btn-group"> 
                    {!! Form::open(['route'=>['user.destroy', $item->id], 'method'=> 'DELETE']) !!}
                    
                    {{Form::button('Zmazať', array('type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Naozaj si prajete zmazať používateľa?")'))}} 
        
                    {{ Form::close() }} 
                  </div>   
                  @endif      
              </div>
          </div>   
      </div>
    </div>
  </div>
</div>
@endsection
