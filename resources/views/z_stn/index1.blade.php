@extends('layouts.portal_app') 
@section('title', 'Zoznam STN - Triedy a skupiny')
@section('stylesheets')  
<style>
  .just-padding {
  padding: 15px;
}

.list-group.list-group-root {
  padding: 0;
  overflow: hidden;
}

.list-group.list-group-root .list-group {
  margin-bottom: 0;
}

.list-group.list-group-root .list-group-item {
  border-radius: 0;
  border-width: 1px 0 0 0;
}

.list-group.list-group-root > .list-group-item:first-child {
  border-top-width: 0;
}

.list-group.list-group-root > .list-group > .list-group-item {
  padding-left: 30px;
}

.list-group.list-group-root > .list-group > .list-group > .list-group-item {
  padding-left: 45px;
}
</style>
<script>
         function getMessage(num){ 
          if(num < 10){
            num = "0" + num; 
          }
            $.ajax({
               type:'GET',
               url:'/zoznam-stn/ajax/'+ num,
               data:'_token = <?php echo csrf_token() ?>',
               success:function(data){
                  $("#msg").html(data.msg);
                  console.log(num);
                  getS(data.msg, data.num);

               }
            });
         }

  function getS(data,num){ 
    
    var ele = 'cist'+ num; 
    console.log(ele);
    var myNode = document.getElementById(ele);
    if(myNode.children.length != 0){

      while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
      }
    }else{
      
      var text = ''; 
      for (i = 0; i < data.length; i++) { 
        text += '<a href="#" class="list-group-item">' + data[i].cisk + ' - '+ data[i].skname + '</a>';
      } 
      myNode.innerHTML = text;
    }
  }

</script>
@endsection
@section('content') 
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
    	    <div class="col-lg-12">
                <h1 class="page-header">@lang('zoznam.h-zoznam-stn')</h1>
            </div>
        </div>
        <div class="row">
        	<div class="col-lg-9">
        		<div class="panel panel-info">
        			<div class="panel-heading">
        				@lang('zoznam.h-class-grups')
        			</div>
        			<div class="panel-body">   
             
            <div class="just-padding">
              <div class="list-group list-group-root well">
            @foreach($items as $item)
  
            <a href="javascript:void(0)" onClick="getMessage({{ $item->cist}})" class="list-group-item">{{ $item->cist}} - {{ $item->skname }}</a>
              <div id='cist{{$item->cist}}' class="list-group"></div>
               
                @endforeach 
                 </div>
               </div>
        			</div>
        		</div>
        	</div>
        	<div class="col-lg-3">
        		<div class="panel panel-info">
        			<div class="panel-heading">
        				@lang('zoznam.h-search')
        			</div>
        			<div class="panel-body"> 
        	  
        			</div>
        		</div>
        	</div>
    	</div>
    </div> 
</div>
@endsection
@section('scripts')  
 
@endsection
