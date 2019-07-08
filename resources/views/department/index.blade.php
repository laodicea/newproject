@extends('layouts.portal_app') 
@section('title', 'Organizačná štruktúra')
@section('stylesheets')
<style>
  .btn{
    padding-left:0;
    padding-right: 0;
  } 
</style> 
@endsection
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
                <h1 class="page-header">@lang('messages.h-org-str')</h1>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-9">
            <div class="panel panel-info">
              <div class="panel-heading">
                @lang('messages.h-org-str')
              </div>
              <div class="panel-body"> 
              @include('partials._messages')  
            <div class="table-responsive">
              <table class="table table-hover"> 
                <thead>
                  <tr>  
                    <th> @lang('messages.tb-mark-short') </th> 
                    <th> @lang('messages.lb-title') </th>  
                    <th> @lang('messages.lb-org-up') </th>
                    <th> @lang('messages.lb-boss') </th> 
                    <th> @lang('messages.tb-action') </th> 
                  </tr>
                </thead>
                <tbody>
                  @foreach($departments as $item)
                    <tr>   
                      <th>{{ $item->short}}</th>
                      <th>{{ $item->name }}</th>   
                      <th>{{ $item->getUpOrg() }}</th>
                      <th>{{ $item->bossSekretar('riadiaci pracovnik') }}</th>  
                      <th>
                    @if(auth()->user()->hasRole('administrator'))
                    
                    <a href="{{ route('department.edit', [$item->id]) }}" class="btn btn-md" title="Editovať"><span class="fa fa-pencil fa-fw"></span>
                    </a> 
                    <a href="{{route('department.show', $item->id) }}" class="btn btn-md" title="Detail"><span class="fa fa-list-alt fa-fw"></span></a>  
                    @endif
                  
                      </th> 
                    </tr>
                  @endforeach  
                </tbody>
              </table> 
            <div class="text-center">
            {!! $departments->links() !!} 
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
          <button type="button" class="btn btn-sm btn-info" style="padding-right:5px;" onclick="window.location='{{ url('service/department/create') }}'"><spam class="fa fa-plus fa-fw"></spam> @lang('messages.btn-create-item')</button> 
        </div>
      </div>
    </div>
  </div>
</div> 
</div>
@endsection
@section('scripts')  
<script type="text/javascript">
  $('.dropdown-menu li').click(function(e){
e.preventDefault();
  var selected = $(this).text();
  $('.type').val(selected);  
}); 
 
</script>
@endsection
