@if($flash=session('policy-create-message'))
<div class="alert alert-success" id="flash">
	{{$flash}}
</div>
@elseif($flash=session('endorsement-create-message'))
<div class="alert alert-success" id="flash">
	{{$flash}}
</div>
@elseif($flash=session('payment-schedules-create-message'))
<div class="alert alert-success" id="flash">
	{{$flash}}
</div>
@elseif($flash=session('message'))
<div class="alert alert-success" id="flash">
	{{$flash}}
</div>
@elseif($flash=session('policy-cancel-message'))
<div class="alert alert-danger" id="flash">
	{{$flash}}
</div>
@elseif($flash=session('vehicle-store-message'))
<div class="alert alert-success" id="flash">
	{{$flash}}
</div>
@elseif($flash=session('message'))
<div class="alert alert-success" id="flash">
	{{$flash}}
</div>
@endif

