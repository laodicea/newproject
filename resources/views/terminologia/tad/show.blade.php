@extends('layouts.portal_app') 
@section('title',  Lang::get('m_tad.title-tad-show')) 
@section('pageName', Lang::get('m_tad.title-tad-show'))
@section('content') 
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">@lang('m_tad.h-tad')</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="panel panel-info">
          <div class="panel-heading">
            @lang('m_tad.h2-detail-tad')
          </div>
          <div class="panel-body">
            @include('partials._messages')      
            <dl class="dl-horizontal">
              <dt>@lang('m_tad.tb-kat_c'):</dt>
              <dd>{{ $item->kat_c}}</dd>

              <dt>@lang('m_tad.tb-skterm'):</dt>
              <dd>{{ $item->skterm }}</dd>

              <dt>@lang('m_tad.tb-skdef'):</dt>
              <dd>{{ $item->skdef}}</dd>

              <dt>@lang('m_tad.tb-sknote'):</dt>
              <dd>{{ $item->sknote}}</dd>

              <dt>@lang('m_tad.tb-enterm'):</dt>
              <dd>{{ $item->enterm }}</dd>

              <dt>@lang('m_tad.tb-endef'):</dt>
              <dd>{{ $item->endef}}</dd>

              <dt>@lang('m_tad.tb-ennote'):</dt>
              <dd>{{ $item->ennote}}</dd>  
            </dl>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="panel panel-info">
          <div class="panel-heading">
            @lang('messages.h-information-item')
          </div>
          <div class="panel-body"> 
           <dl class="dl-vertical">
             <dt>{{ __('messages.p-created_at')}}:</dt>
             <dd>{{ date('j M, Y H:i', strtotime($item->created_at)) }}</dd> 
             <dt>{{ __('messages.p-updated_at')}}:</dt>
             <dd>{{ date('j M, Y H:i', strtotime($item->updated_at)) }}</dd>
             <dt>{{ __('messages.p-create-user') }}:</dt>
             <dd>{{ $item->user->fullname() }}</dd>
           </dl> 
         </div>
       </div> 
     </div>
     <div class="col-lg-4">
     <div class="panel panel-info">
      <div class="panel-heading">
        @lang('m_tad.h-nav')
      </div>
      <div class="panel-body"> 
       <div class="btn-group">
         <a href="{{ url('terminologia/tad')}}" class="btn btn-info btn-block btn-sm"><i class="fa fa-arrow-left fa-fw"></i> {{ __('messages.btn-back')}}</a> 
       </div>
       @if(auth()->user()->hasAnyRole(['term-tad','administrator']))
       <div class="btn-group">
        <button type="button" class="btn btn-primary btn-sm" onclick="window.location='{{ Route('tad.create') }}'"><span class="fa fa-plus fa-fw"></span> Vytvoriť</button> 
      </div>
      <div class="btn-group">
        <a href="{{ URL::route('tad.edit', $item->id) }}" class="btn btn-primary btn-block btn-sm"><i class="fa fa-pencil fa-fw"></i> {{__('messages.btn-edit')}}</a>
      </div>
      <div class="btn-group">
        {!! Form::open(['route' => ['tad.destroy', $item->id], 'method'=>'DELETE']) !!}
        {{Form::button('Zmazať', array('type' => 'submit', 'class' => 'btn btn-danger btn-block btn-sm', 'onclick' => 'return confirm("Naozaj si prajete zmazať zvolený termín a definíciu?")'))}} 
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
