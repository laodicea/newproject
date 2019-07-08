@extends('layouts.portal_app') 
@section('title',  'OTN - zobrazenie návrhu na zrušenie STN') 
@section('pageName', 'Zobrazenie návrhu na zrušenie STN')
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
                @lang('otn.h-navrhy-na-zrusenie-stn')
              </div>
              <div class="panel-body">
              @include('partials._messages') 
              	<h2 class="text-center">{{ $item->ozn }}</h2> 
				<dl class="dl-horizontal">
					<dt>{{ __('otn.lb-katc') }}:</dt>
					<dd>{{ $item->kat_c }}</dd>
			        <dt>{{ __('messages.lb-ozn') }}:</dt>
			        <dd>{{ $item->ozn }}</dd>
			        <dt>{{ __('messages.lb-nazov') }}:</dt>
			        <dd>{{ $item->nazov  }}</dd>
			        <dt>{{ __('otn.lb-date-approvap-release') }}:</dt>
			        <dd>{{ $item->getDateVyd()  }}</dd>
			        <dt>{{ __('otn.lb-date-canceled') }}:</dt>
			        <dd>{{ $item->getDateNavZru() }}</dd>
			        <dt>{{ __('messages.lb-zodp-employee') }}:</dt>
			        <dd>{{ $item->zodp_zam }}</dd>
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
				<dt>Vytvorené:</dt>
				<dd>{{ $item->getCreatedAt() }}</dd>
				<dt>Posledné zmeny:</dt>
				<dd>{{ $item->getUpdatedAt() }}</dd>
				<dt>Vytvoril:</dt>
				<dd>{{ $item->user->fullname() }}</dd> 
				<dt>Publikovaný záznam ako dataset:</dt>
				<dd>{{ $item->isPublic() }}</dd> 
				</dl> 
			  </div>
		   	</div>

            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-nav')
              </div>
              <div class="panel-body"> 
              	<div class="col-sm-4">
              <button type="button" class="btn btn-primary bt-sm" onclick="window.location='{{ url('otn/navrh-zrusenia-stn')}}'"><span class="fa fa-arrow-left fa-fw" ></span> {{ __('messages.btn-back')}}</button>  
				</div>
				@if (auth()->user()->hasAnyRole(['otn','administrator']))
				<div class="col-sm-4">
			 		{!! Html::linkRoute('navrh-zrusenia-stn.edit', Lang::get('messages.btn-edit'), array($item->kat_c), array('class'=> 'btn btn-success bt-sm')) !!}
			 	</div>
	 		 	<div class="col-sm-4">
					{!! Form::open(['route' => ['navrh-zrusenia-stn.destroy', $item->kat_c], 'method'=>'DELETE']) !!}
			
					{!! Form::submit(Lang::get('messages.btn-delete'), ['class'=> 'btn btn-danger bt-sm','onclick' => 'return confirm("Naozaj si prajete zmazať položku?")']) !!}
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
