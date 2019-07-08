@extends('layouts.portal_app') 
@section('title',  Lang::get('m_obsah.title-obsah'))  
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
                @lang('m_obsah.h-obsah-index')
              </div>
              <div class="panel-body">   
              @include('partials._messages')  
            <div class="table-responsive">
              @if(isset($items)) 
              <table class="table table-hover">
                <thead> 
                 <tr> 
                  <th>{{ __('m_obsah.lb-katc')}}</th> 
                  <th>{{ __('m_obsah.tb-create-by-user')}}</th>
                  <th>{{ __('m_obsah.tb-date-create')}}</th>
                  <th>#</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $item)
                  <tr> 
                    <td><a href="{{ route('obsahy.show', $item->kat_c) }}">{{ $item->kat_c}}</a></td> 
                    <td>{{ $item->user->fullname() }}</td>
                    <td>{{ $item->getCreatedAt() }}</td>
                    <td><a href="{{ route('obsahy.edit', $item->kat_c) }}"title="Upraviť"><span class="fa fa-pencil fa-fw"></span></a> 
                        <a href="{{route('obsahy.show', $item->kat_c) }}"  title="Detail"><span class="fa fa-list-alt fa-fw"></span></a></td></tr>
                @endforeach  
              </tbody>
            </table> 
        <div class="text-center">
          {!! $items->links() !!}                        
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
          @lang('m_obsah.h2-create-obsah')
        </div>
        <div class="panel-body">  
          <button type="button" class="btn btn-primary btn-sm" onclick="window.location='{{ Route('obsahy.create') }}'"><span class="fa fa-plus fa-fw"></span> @lang('m_obsah.btn-create-obsah')</button>  
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-info">
        <div class="panel-heading">
          @lang('messages.h-search')
        </div>
        <div class="panel-body"> 
          <form name="_token" action="{{ route('obsahy.search') }}" id="type-dropdown" method="post" value="<?php echo csrf_token(); ?>">
            {!! csrf_field() !!}
          <div class="input-group"> 
            <input class="form-control" type="text" placeholder="Vyhľadávanie podľa publikačného čísla" name="search">
            <span class="input-group-btn"> 
                <button class="btn btn-primary" type="submit"><i class="fa fa-search fa-fw"></i> Vyľadaj</button>
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


