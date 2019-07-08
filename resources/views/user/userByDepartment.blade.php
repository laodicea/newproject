@extends('layouts.portal_app') 
@section('title', 'Používatelia portálu') 
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
                <h1 class="page-header">@lang('messages.h-user-portal')</h1>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-9">
            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-list-users')
              </div>
              <div class="panel-body"> 
              @include('partials._messages')  
            <div class="table-responsive">
              <table class="table table-hover"> 
                <thead>
                  <tr>     
                    <th class="col-sm-2"> @lang('messages.h-org-str') </th>
                    <th class="col-sm-1"> @lang('messages.lb-boss') </th>
                    <th class="col-sm-3"> @lang('messages.lb-employee') </th> 
                  </tr>
                </thead>
                <tbody>
                  @foreach($items as $item)
                    <tr> 
                      <td>{{ $item->name }} ({{ $item->short }})</td>
                      <td><a href="#" data-toggle="tooltip" data-placement="top" title="{{ $item->bossSekretarTelRoom('riadiaci pracovnik') }}">{{ $item->bossSekretar('riadiaci pracovnik') }}</a></td>  
                      <td>@foreach($item->getUsers() as $value)
                     <a href="#" data-toggle="tooltip" data-placement="top" title="Miestnosť: {{$value->room}}, Telefón: {{$value->phone}}">{{ $value->lastname }} {{ $value->name }}</a><br>
                      @endforeach
                      </td> 
                    </tr>
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
      <div class="panel panel-info">
        <div class="panel-heading">
          @lang('messages.h-nav')
        </div>
        <div class="panel-body"> 
          <div class="btn-group" style="margin-bottom: 4px;">
            <a href="{{ route('user.index') }}" class="btn btn-sm btn-info"><span class="fa fa-list fa-fw"></span> Zoznam zamestnancov</a>   
          </div>
          <div class="btn-group" style="margin-bottom: 4px;">
            <a href="{{ route('user.excel') }}" class="btn btn-sm btn-info"><span class="fa fa-file-excel-o fa-fw"></span> Exportovať do XLS</a> 
          </div>
          <div class="btn-group ">
            <button type="button" class="btn btn-sm btn-info"  onclick="window.location='{{ url('user/create') }}'"><spam class="fa fa-plus fa-fw"></spam>@lang('messages.btn-create-employee')</button> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div> 
</div>
@endsection  




 
              
            
                   
                                    
                  
