@extends('layouts.portal_app') 
@section('title', 'ZPV - všetky ZPC')
@section('stylesheets')  
<script>
         function getMessage(num){ 
          console.log(num);
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
    var myNode = document.getElementById(ele);
    if(myNode.children.length != 0){

      while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
      }
    }else{
      console.log('select');
      var text = ''; 
      for (i = 0; i < data.length; i++) { 
        text += '<button type="button" class="list-group-item list-group-item-action" href="www.google.sk">' + data[i].cist + ' - '+ data[i].skname + '</button>';
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
                <h1 class="page-header">@lang('zpc.h-zpcs')</h1>
            </div>
        </div>
        <div class="row">
        	<div class="col-lg-9">
        		<div class="panel panel-info">
        			<div class="panel-heading">
        				@lang('zpc.h-zpcs')
        			</div>
        			<div class="panel-body">   
              <ul class="list-group list-group-flush">
               
            @foreach($items as $item)
              <li class="list-group-item" onClick="getMessage({{ $item->cist}})"> {{ $item->cist}} - {{ $item->skname }}
                  
                <div id='cist{{$item->cist}}' class="list-group">
                  
                </div>
              </li> 
                @endforeach 
              </ul>    
        			</div>
        		</div>
        	</div>
        	<div class="col-lg-3">
        		<div class="panel panel-info">
        			<div class="panel-heading">
        				@lang('zpc.h-search')
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
