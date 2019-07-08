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
        				@lang('messages.h-inform-sec-category-detail')
        			</div>
        		<div class="panel-body"> 
	 				@include('partials._messages')  
					<h3 style="text-align: center;">Kategória oznamu: {{ $item->name }}</h3>   
            <div class="table-responsive">
              <table class="table table-hover"> 
                <thead>
                  <tr>  
                    <th> @lang('messages.tb-naz') </th>
                    <th> @lang('messages.lb-text') </th>  
                    <th> @lang('messages.lb-date-create') </th> 
                    <th> @lang('messages.lb-action') </th>
                  </tr>
                </thead>
                <tbody>
                   @foreach($item->getAllItemsInCategoryes() AS $oznam) 
                    <tr> 
                      <td>{{ $oznam->title }}</td>
                      <td>{!! $oznam->getTextShort() !!}</td> 
                      <td>{{ $oznam->getCreatedAt() }}</td>
                      <td> 
                        <a href="{{url('security-inform/'.$oznam->slug)}}" class="btn btn-sm btn-default">Čítať..</a> 
                      </td> 
                    </tr>
                  @endforeach  
                </tbody>
              </table> 
            <div class="text-center">
            {!! $item->getAllItemsInCategoryes()->links() !!} 
          </div>                  
        </div> 
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
                   <button type="button" class="btn btn-default btn-sm" onclick="window.location='{{ route('security-category.index') }}'" ><span class="fa  fa-arrow-left fa-fw"></span> {{ __('messages.btn-back')}}</button>
                </div>  
                  @if (auth()->user()->hasAnyRole(['security_inform','administrator']))
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location='{{ URL::route('security-category.edit', $item->id) }}'" ><span class="fa fa-pencil fa-fw"></span> {{__('messages.btn-edit')}}</button> 
                  </div>
                  <div class="btn-group">
                    {!! Form::open(['route' => ['security-category.destroy', $item->id], 'method'=>'DELETE']) !!}
                      {{Form::button('Zmazať', array('type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Naozaj si prajete zmazať kategóriu oznamu z informačnej bezpečnosti?!")'))}} 
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
