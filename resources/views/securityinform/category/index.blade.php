@extends('layouts.portal_app') 
@section('title', 'Kategórie informačnej bezpečnosti') 
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-header">@lang('messages.h-inform-sec')</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-9">
            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-inform-sec-category')
              </div>
              <div class="panel-body"> 
              @include('partials._messages')  
            <div class="table-responsive">
              <table class="table table-hover"> 
                <thead>
                  <tr>  
                    <th class="col-sm-2"> @lang('messages.lb-title') </th>
                    <th class="col-sm-1"> @lang('messages.lb-num-items') </th> 
                  </tr>
                </thead>
                <tbody>
                   @foreach($items as $item)
                      <tr> 
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->securityInforms()->count() }}</td>
                        
                        <td> 
                        <a href="{{url('security-category/'.$item->id)}}" class="btn btn-sm btn-default">Viac..</a> 
                      </td> 
                  @endforeach  
                </tbody>
              </table> 
            <div class="text-center">
            {!! $items->links() !!} 
          </div>                  
        </div>   
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="row">
      @if (auth()->user()->hasAnyRole(['security_inform','administrator'])) 
      <div class="panel panel-info">
        <div class="panel-heading">
          @lang('messages.h-crate-category')
        </div>
        <div class="panel-body">  
            <form name="_token" action="{{ route('security-category.store') }}" id="type-dropdown" method="post" value="<?php echo csrf_token(); ?>">
            {!! csrf_field() !!}
            <div class="input-group"> 
              <input class="form-control" type="text" placeholder="Názov kategórie" name="name">
              <span class="input-group-btn"> 
                <button class="btn btn-primary" type="submit"><i class="fa fa-plus fa-fw"></i> @lang('messages.btn-create')</button>
              </span>
            </div>
          </form> 
        </div>
      </div>  
      @endif 
      <div class="panel panel-info">
        <div class="panel-heading">
          @lang('messages.h-search')
        </div>
        <div class="panel-body">  
          <form name="_token" action="{{ route('security-category.search') }}" id="type-dropdown" method="post" value="<?php echo csrf_token(); ?>">
            {!! csrf_field() !!}
            <div class="input-group"> 
              <input class="form-control" type="text" placeholder="Vyhľadávanie podľa kategórie" name="search">
              <span class="input-group-btn"> 
                <button class="btn btn-info" type="submit"><i class="fa fa-search fa-fw"></i> @lang('messages.btn-search')</button>
              </span>
            </div>
          </form> 
        </div>
      </div>
    </div>
    </div> 
  </div>
</div> 
</div>
@endsection  
