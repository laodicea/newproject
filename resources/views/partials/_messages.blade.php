@if (Session::has('success'))
<div class="alert alert-success" role="alert">

    <strong>OK: </strong>{{ Session::get('success') }}</div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger" role="alert">

    <strong>Varovanie: </strong>{{ Session::get('error') }}</div>
@endif
@if(count($errors) >0)
	<div class="alert alert-danger" role="alert">
	  <strong>Errors</strong>
	  <ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
     </div
@endif




 
