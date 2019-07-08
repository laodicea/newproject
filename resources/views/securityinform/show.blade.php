@extends('layouts.portal_app')
@section('title', 'Informačná bezpečnosť')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
    	    <div class="col-sm-12">
                <h1 class="page-header">@lang('messages.h-inform-sec')</h1> 
            </div>
        </div>
        <div class="row"> 
        	<div class="col-lg-9">
        		<div class="panel panel-info">
        			<div class="panel-heading">
        				@lang('messages.h-inform-sec-detail')
        			</div>
        		<div class="panel-body"> 
	 				@include('partials._messages')  
					<h3 style="text-align: center;">{{ $item->title }}</h3>  
				<p>{{ $item->description}}</p> 
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
              <dt>{{__('messages.lb-created')}}:</dt>
              <dd>{{ $item->user->fullname() }}</dd>
              <dt>{{__('messages.lb-date-create')}}:</dt>
              <dd>{{ $item->getCreatedAt() }}</dd> 
              <dt>{{__('messages.lb-updated_at')}}:</dt>
              <dd>{{ $item->getUpdatedAt() }}</dd>
              <hr>
              <dt>{{__('messages.lb-category')}}:</dt> 
              <dd>{{ $item->category()->name }}</dd>
              <dt>{{__('messages.lb-attachments')}}:</dt> 
              <dd>@foreach($item->files as $file)
                    <a href="{{route('security-inform.download', [$item->slug, $file->name]) }}" class="btn btn-md" title="Stiahnúť súbor" target="_blank"><span class="fa fa-file-text fa-fw"></span>
                    </a>{{ $file->filename }}<br>
                  @endforeach
             </dd>
            </dl> 
          </div>
        </div>  
          <div class="panel panel-info">
               <div class="panel-heading">
                  @lang('messages.h-nav')
              </div>
              <div class="panel-body"> 
                <div class="btn-group" style="margin-bottom: 4px;">
                   <button type="button" class="btn btn-default btn-sm" onclick="window.location='{{ route('security-inform.index') }}'" ><span class="fa  fa-arrow-left fa-fw"></span> {{ __('messages.btn-back')}}</button>
                </div>  
                  @if (auth()->user()->hasAnyRole(['security_inform','administrator']))
                  <div class="btn-group" style="margin-bottom: 4px;">
                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location='{{ URL::route('security-inform.edit', $item->slug) }}'" ><span class="fa fa-pencil fa-fw"></span> {{__('messages.btn-edit')}}</button> 
                  </div>
                  <div class="btn-group" style="margin-bottom: 4px;">
                    {!! Form::open(['route' => ['security-inform.destroy', $item->slug], 'method'=>'DELETE']) !!}
                      {{Form::button('Zmazať', array('type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Naozaj si prajete zmazať oznam z informačnej bezpečnosti?!")'))}} 
                  </div>
                      {!! Form::close() !!} 

                  <div class="btn-group" style="margin-bottom: 4px;">
                    <button type="button" class="btn btn-warning btn-sm" onclick="window.location='{{ Route('security-inform.notify', $item->slug) }}'" ><span class="fa fa-bullhorn fa-fw"></span> {{__('messages.btn-notify')}}</button> 
                  </div> 
                  @endif      
              </div>
          </div> 
      </div>
    </div>
  </div>
</div>
@endsection
