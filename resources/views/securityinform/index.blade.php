inde
@extends('layouts.portal_app') 
@section('title', 'Informačná bezpečnost') 
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
                @lang('messages.h-inform-sec')
              </div>
              <div class="panel-body"> 
              @include('partials._messages')  
            <div class="table-responsive">
              <table class="table table-hover"> 
                <thead>
                  <tr>  
                    <th> @lang('messages.tb-naz') </th>
                    <th> @lang('messages.lb-text') </th> 
                    <th> @lang('messages.lb-category') </th> 
                    <th> @lang('messages.lb-date-create') </th> 
                    <th> @lang('messages.lb-action') </th>
                  </tr>
                </thead>
                <tbody>
                   @foreach($items as $item)
                      <tr> 
                        <td>{{ $item->title }}</td>
                        <td>{!! $item->getTextShort() !!}</td>
                        <td>{{ $item->category()->name }}</td>
                        <td>{{ $item->getCreatedAt() }}</td>
                        <td><a href="{{url('security-inform/'.$item->slug)}}" class="btn btn-sm btn-default">Čítať..</a></td> 
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
        <div class="row">
          @if (auth()->user()->hasAnyRole(['security_inform','administrator']))
            <div class="panel panel-info">
             <div class="panel-heading">
              @lang('messages.h-nav')
            </div>
            <div class="panel-body">
              <div class="btn-group"> 
                <button type="button" class="btn btn-primary btn-sm" onclick="window.location='{{ Route('security-inform.create') }}'">{{ __('messages.btn-create-inform')}}</button> 
              </div> 
            </div>
          </div>
      @endif
      <div class="panel panel-info">
        <div class="panel-heading">
          @lang('messages.h-search')
        </div>
        <div class="panel-body"> 
          <form name="_token" action="{{ route('security-inform.filter') }}" id="type-dropdown" method="get" value="<?php echo csrf_token(); ?>">
            {!! csrf_field() !!}
            <div class="input-group col-sx-8">
              @if(isset($search))
                <input class="form-control" type="text" value="{{ $search }}" placeholder="Vyhľadaj slovo" name="search">
              @else
                <input class="form-control" type="text" value="" placeholder="Vyhľadaj slovo" name="search">
              @endif
              <div class="input-group-btn">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Kategória oznamu <span class="caret"></span></button> 
                <ul class="ldropdown-menu">
                  <li><a href="#">Všetky</a></li> 
                    @foreach ($types as $type)
                  <li><a href="#">{!! $type->name !!}</a></li>  
                    @endforeach 
                    </ul>
                    <input type="hidden" name="type" class="type">
                  </div> 
                  </div>
                  <br>
                  <button class="btn btn-primary col-sx-3" type="submit">@lang('messages.btn-search')</button>
                </form> 
              </div>
            </div> 
        </div> 
      </div>  
    </div>
  </div> 
</div>
@endsection  
@section('scripts')  
<script type="text/javascript">
  $('.ldropdown-menu li').click(function(e){
      e.preventDefault();
      
      var lselected = $(this).text();
      $('.type').val(lselected);  
  }); 
</script>
@endsection
