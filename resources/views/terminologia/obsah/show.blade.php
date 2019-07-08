@extends('layouts.portal_app') 
@section('title',  Lang::get('m_obsah.title-obsah-show')) 
@section('pageName', Lang::get('m_obsah.title-obsah-show'))
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
                <h1 class="page-header">@lang('m_obsah.h-obsah')</h1>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-9">
            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('m_obsah.h-obsah-show')
              </div>
              <div class="panel-body">
              @include('partials._messages') 
              	<h2 class="text-center">{{ $item->ozn }}</h2> 
				<dl class="dl-horizontal">
					<dt>@lang('m_obsah.lb-katc'):</dt>
					<dd>{{ $item->kat_c }}</dd>
			        <dt>@lang('m_obsah.lb-obsah'):</dt>
			        <dd>{{ $item->obsah }}</dd> 
			    </dl>
		   	   </div>
		    </div>
	 	</div>
 		<div class="col-lg-3">
 			<div class="row">
 			<div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-information-item')
              </div>
              <div class="panel-body"> 
		    	<dl class="dl-vertical">
					<dt>Vytvorené:</dt>
					<dd>{{ $item->getCreatedAt() }}</dd>
					<dt>Posledné zmeny:</dt>
					<dd>{{ $item->getUpdatedAt() }}</dd>
					<dt>Vytvoril:</dt>
					<dd>{{ $item->user->fullname() }}</dd>   
				</dl> 
			  </div>
		   	</div>

            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-nav')
              </div>
              <div class="panel-body">  
              		<div class="btn-group" style="margin-bottom: 4px;">
              <button type="button" class="btn btn-primary btn-sm" onclick="window.location='{{ route('obsahy.index')}}'"><span class="fa fa-arrow-left fa-fw" ></span> {{ __('messages.btn-back')}}</button>  
				</div>
				 
				<div class="btn-group" style="margin-bottom: 4px;">
			 		{!! Html::linkRoute('obsahy.edit', Lang::get('messages.btn-edit'), array($item->kat_c), array('class'=> 'btn btn-success btn-sm')) !!}
			  	</div>
	 		  	<div class="btn-group" style="margin-bottom: 4px;">
					{!! Form::open(['route' => ['obsahy.destroy', $item->kat_c], 'method'=>'DELETE']) !!}
			
					{!! Form::submit(Lang::get('messages.btn-delete'), ['class'=> 'btn btn-danger btn-sm','onclick' => 'return confirm("Naozaj si prajete zmazať položku?")']) !!}
					{!! Form::close() !!} 
				</div>
			 
			  </div>
		   	</div>
		   	</div>
		</div> 
	</div>	
</div> 
</div>
@endsection
