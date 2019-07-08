@extends('layouts.portal_app') 
@section('title', 'Notifikácie') 
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-header">@lang('messages.h-notifications')</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-messages-unread')
              </div>
              <div class="panel-body"> 
              @include('partials._messages')  
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
                  @foreach($unreads as $item)
                   @if(strpos($item->type, 'SecurityInform'))
                    <tr> 
                      <td>@lang('messages.h-inform-sec') <small></small></td>  
                      <td><span class="text-danger">{{ $item->getTitle() }}</span> - {{ $item->getText() }}</td>
                      <td>{{ $item->created_at }}
                      <td> 
                        <a href="{{ url($item->getShowLink()) }}" class="btn btn-sm btn-default">Čítať..</a> 
                      </td> 
                    </tr>
                    @endif
                  @endforeach  
                </tbody>
              </table> 
            <div class="text-center">
            {!! $unreads->links() !!} 
          </div>                  
        </div>   
      </div>
    </div>
  </div>
   <div class="col-lg-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-messages-read')
              </div>
              <div class="panel-body"> 
              @include('partials._messages')  
            <div class="table-responsive">
              <table class="table table-hover"> 
                <thead>
                  <tr>  
                    <th> @lang('messages.tb-naz') </th>
                    <th> @lang('messages.lb-text') </th>  
                    <th> @lang('messages.lb-date-mark-as-read') </th> 
                    <th> @lang('messages.lb-action') </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($reads as $item)
                   @if(strpos($item->type, 'SecurityInform'))
                    <tr> 
                      <td>@lang('messages.h-inform-sec') <small></small></td>  
                      <td><span class="text-danger">{{ $item->getTitle() }}</span> - {{ $item->getText() }}</td>
                      <td>{{ $item->created_at }}
                      <td> 
                        <a href="{{ url($item->getShowLink()) }}" class="btn btn-sm btn-default">Čítať..</a> 
                      </td> 
                    </tr>
                    @endif
                  @endforeach  
                </tbody>
              </table> 
              <div class="text-center">
              {!! $reads->links() !!} 
              </div>                  
            </div>   
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>  
@endsection  
