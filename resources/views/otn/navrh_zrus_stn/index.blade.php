@extends('layouts.portal_app') 
@section('title',  Lang::get('otn.h-navrh-zrusenia-stn')) 
@section('pageName', 'Vkladanie návrhov na zrušenie STN')
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
            <div class="table-responsive">
              @if(isset($items))
              <table class="table table-hover">
                <thead>
                  <tr> 
                   <th>@lang('otn.lb-katc')</th> 
                    <th>@lang('otn.lb-oznacenie')</th>
                    <th>@lang('otn.lb-date-approvap-release')</th>
                    <th>@lang('otn.lb-date-canceled')</th>
                    <th>@lang('messages.lb-zodp-employee')</th> 
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($items as $item)
                    <tr> 
                      <td><a href="{{ route('navrh-zrusenia-stn.show', $item->kat_c) }}">{{ $item->kat_c}}</a></td>
                      <td>{{ $item->ozn }}</td> 
                      <td>{{ $item->getDateVyd() }}</td>
                      <td>{{ $item->getDateNavZru() }}</td>
                      <td>{{ $item->zodp_zam }}</td> 
                      <td><a href="{{ route('navrh-zrusenia-stn.edit', $item->kat_c) }}"  title="Upraviť"><span class="fa fa-pencil fa-fw"></span></a> 
                          <a href="{{route('navrh-zrusenia-stn.show', $item->kat_c) }}"  title="Detail"><span class="fa fa-list-alt fa-fw"></span></a></td>
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
          @lang('otn.h-crate-new-canceled-stn')
        </div>
        <div class="panel-body"> 
          @if (auth()->user()->hasAnyRole(['otn','administrator']))   
              <button type="button" class="btn btn-primary" onclick="window.location='{{ Route('navrh-zrusenia-stn.create') }}'"><span class="fa fa-plus fa-fw"></span> Vytvoriť</button> 
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
          <form name="_token" action="{{ route('navrh-zrusenia-stn.search') }}" id="type-dropdown" method="post" value="<?php echo csrf_token(); ?>">
            {!! csrf_field() !!}
          <div class="input-group"> 
            <input class="form-control" type="text" placeholder="Vyhľadávanie podľa publikačného čísla" name="search">
            <span class="input-group-btn"> 
                <button class="btn btn-primary" type="submit">Vyľadaj</button>
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

  

