@extends('layouts.portal_app') 
@section('title',  Lang::get('m_tad.title-tad'))  
@section('content') 
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">@lang('m_tad.h-tad')</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-9">
        <div class="panel panel-info">
          <div class="panel-heading">
            @lang('m_tad.h-tad-index')
          </div>
          <div class="panel-body">   
            @include('partials._messages')  
            <div class="table-responsive">
              @if(isset($items)) 
              <table class="table table-hover">
                <thead> 
                  <tr> 
                    <th>@lang('m_tad.tb-kat_c')</th>
                    <th>@lang('m_tad.tb-skterm')</th> 
                    <th>@lang('m_tad.tb-enterm')</th>
                    <th>@lang('m_tad.tb-create-by-user')</th>
                    <th>@lang('m_tad.tb-date-create')</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr> 
                      <td><a href="{{ route('tad.show', $item->id) }}">{{ $item->kat_c}}</a></td>
                      <td>{{ $item->skterm }}</td>
                      <td>{{ $item->enterm }}</td>
                      <td>{{ $item->user->fullname() }}</td>
                      <td>{{ $item->getCreatedAt() }}</td>
                      <td><a href="{{ route('tad.edit', $item->id) }}" title="Upraviť"><span class="fa fa-pencil fa-fw"></span></a> 
                        <a href="{{route('tad.show', $item->id) }}" title="Detail"><span class="fa fa-list-alt fa-fw"></span></a></td>
                      </tr>
                      @endforeach  
                  </tbody>
                </table>   
                <div class="text-center">
                 {!! $items->render() !!}                        
               </div> 
              @else  
                {{ $mesage }}  
              @endif
            </div>
         </div>
       </div>
     </div>
     <div class="col-lg-3">
      <div class="row">
      <div class="panel panel-info">
        <div class="panel-heading">
          @lang('m_tad.h-tad-create')
        </div>
        <div class="panel-body"> 
          @if (auth()->user()->hasAnyRole(['term-tad','administrator']))   
          <button type="button" class="btn btn-primary" onclick="window.location='{{ Route('tad.create') }}'"><span class="fa fa-plus fa-fw"></span> Vytvoriť</button> 
          @endif
        </div>
      </div>
    </div>
    <div class="row"> 
      <div class="panel panel-info">
        <div class="panel-heading">
          @lang('messages.h-search')
        </div>
        <div class="panel-body"> 
          <form name="_token" action="{{ route('tad.search') }}" id="type-dropdown" method="post" value="<?php echo csrf_token(); ?>">
            {!! csrf_field() !!}
            <div class="input-group"> 
              <input class="form-control" type="text" placeholder="Vyhľadávanie podľa publikačného čísla" name="search"> 
              <span class="input-group-btn"> 
                <button class="btn btn-primary" type="submit">@lang('messages.btn-search')</button>
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
@section('scripts')  
@endsection


