 @extends('layouts.portal_app') 
@section('title', 'Používatelia portálu') 
@section('stylesheets') 
{!! Html::style('css/select2.min.css') !!}
@endsection
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
                @lang('messages.h-crate-user') 
              </div>
              <div class="panel-body"> 
              @include('partials._messages') 
               
              {!! Form::open(array('route' => 'user.store')) !!}

              {!! csrf_field() !!}
 
              <div class="form-group">
              {{ Form::label('name','Meno') }}
              {{ Form::text('name', null, array('class' => 'form-control', 'required' => 'required'))}}
              </div>
              <div class="form-group">
              {{ Form::label('lastname','Priezvisko') }}
              {{ Form::text('lastname', null, array('class' => 'form-control', 'required' => 'required'))}}
              </div>
              <div class="form-group">
              {{ Form::label('degree','Titul') }}
              {{ Form::text('degree', null, array('class' => 'form-control'))}}
              </div> 
              <div class="form-group">
              {{ Form::label('email','Email') }}
              {{ Form::text('email', null, array('class' => 'form-control', 'required' => 'required'))}}
              </div> 
              <div class="form-group">
               {{ Form::label('department_id','Odbor/oddelenie',['class' => 'form-spacing-top']) }}
                {{ Form::select('department_id', $departments, null, ['class'=>'form-control']) }}
              </div>   
              <div class="form-group">
                {{ Form::label('phone','Telefón') }}
                {{ Form::text('phone', null, array('class' => 'form-control', 'required' => 'required'))}}  
              </div>
              <div class="form-group">
                {{ Form::label('room','Kancelária') }}
                {{ Form::text('room', null, array('class' => 'form-control', 'required' => 'required'))}} 
              </div>
              <div class="form-group">
                {{ Form::label('roles','Používateľské role',['class' => 'form-spacing-top']) }}
                {{ Form::select('roles[]', $roles, null, ['class'=>'form-control select2-multi', 'multiple' => 'multiple']) }}
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
              <div class="btn-group">
                <button type="submit" class="btn btn-sm btn-success" value="send" name="submitbutton">Uložiť zmeny</button>
                {!! Form::close() !!}
              </div>
              <div class="btn-group">
               <button type="button" class="btn btn-sm btn-info" onclick="window.location='{{ route('user.index') }}'">{{ __('messages.btn-back')}}</button> 
              </div>  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
@endsection
@section('scripts')  
{!! Html::script('js/select2.min.js') !!}
<script type="text/javascript">
    $('.select2-multi').select2();
</script>
@endsection

  






 

 
            
 
 
