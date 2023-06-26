@extends('layouts.app')
@section('content')
<style type="text/css">
	.mys{
		width: 100%;
background-color: #f4f4f4;
border: 1px solid transparent;
border-radius: 0;
line-height: 23px;
padding: 10px 20px;
font-size: 14px;
height: 45px;
color: #14191e;
margin-bottom: 15px;
	}
</style>
<section class="breadcrumb-section">
	<h2 class="sr-only">Site Breadcrumb</h2>
	<div class="container">
		<div class="breadcrumb-contents">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html">Home</a></li>
					<li class="breadcrumb-item active">Checkout</li>
				</ol>
			</nav>
		</div>
	</div>
</section>
<main id="content" class="page-section inner-page-sec-padding-bottom space-db--20">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<!-- Checkout Form s-->
				<div class="checkout-form">
					<div class="row row-40">
						<div class="col-12">
							<h1 class="quick-title">Checkout</h1>
							<!-- Slide Down Trigger  -->
							@guest
							<div class="checkout-quick-box" id="checklogin">
								<p><i class="far fa-sticky-note"></i>Returning customer? <a href="javascript:"
									class="slide-trigger" data-target="#quick-login">Click
								here to login</a></p>
							</div>
							@endguest
							<!-- Slide Down Blox ==> Login Box  -->
							<div class="checkout-slidedown-box" id="quick-login">
								
								<form method="post" id="userloginform">
									<div class="quick-login-form">
										@guest
										<p>If you have shopped with us before, please enter your details in the
											boxes below. If you are a new
											customer
											please
										proceed to the Billing & Shipping section.</p>
										
										<div class="form-group">
											<div id="loginerror" class="text-danger">
											</div>
											<label for="quick-user">email *</label>
											<input required type="text" placeholder="" id="loginemail">
										</div>
										<div class="form-group">
											<label for="quick-pass" >Password *</label>
											<input required type="text" placeholder="" id="loginpassword" >
										</div>
										<div class="form-group">
											<div class="d-flex align-items-center flex-wrap">
												<button type="submit" class="btn btn-outlined me-3">Login</button>
												<div class="d-inline-flex align-items-center">
													<input required type="checkbox" id="accept_terms" class="mb-0 mx-1">
													<label for="accept_terms" class="mb-0">I’ve read and accept
													the terms &amp; conditions</label>
												</div>
											</div>
											<p><a href="javascript:" class="pass-lost mt-3">Lost your
											password?</a></p>
										</div>
										@endguest
									</form>
								</div>
								
							</div>
							<!-- Slide Down Trigger  -->
							
							<!-- Slide Down Blox ==> Cupon Box -->
							
						</div>
						<div class="col-lg-7 mb--20">
							<!-- Billing Address -->
							<form method="post" action="{{url('/placeorder')}}" >
								@csrf
								<span id="formdata">
									<div id="billing-form" class="mb-40">
										<h4 class="checkout-title">Billing Address</h4>
										<div class="row">
											<div class="col-md-6 col-12 mb--20">
												<label>First Name*</label>
												<input required type="text" name="fname" placeholder="First Name" value="{{auth()->user()?auth()->user()->fname:''}}">
											</div>
											<div class="col-md-6 col-12 mb--20">
												<label>Last Name*</label>
												<input required type="text" name="lname" placeholder="Last Name" value="{{auth()->user()?auth()->user()->lname:''}}">
											</div>
											<div class="col-12 mb--20">
												<label>Company Name</label>
												<input  type="text" name="cname" placeholder="Company Name" value="{{auth()->user()?auth()->user()->cname:''}}">
											</div>
											
										</div>
										<div class="row">
											<div class="col-md-6 col-12 mb--20">
												<label>Email Address*</label>
												@if(auth()->user())
												<input required type="email" readonly name="email" placeholder="Email Address" value="{{auth()->user()->email}}">
												@else
												<input required type="email" name="email" placeholder="Email Address" value="">
												@endif
											</div>
											<div class="col-md-6 col-12 mb--20">
												<label>Phone no*</label>
												<input required type="text" name="phone" placeholder="Phone number" value="{{auth()->user()?auth()->user()->phone:''}}">
											</div>
										</div>
										
										<div class="col-12 mb--20">
											<label>Address*</label>
											<input required type="text" name="address1" placeholder="Address line 1" value="{{auth()->user()?auth()->user()->address1:''}}">
											<input required type="text" name="address2" placeholder="Address line 2"
											value="{{auth()->user()?auth()->user()->address2:''}}">
										</div>
										<div class="col-12 col-12 mb--20">
											<div class="row">
												
												
												<div class="col-md-6 col-12 mb--20">
													<label>City</label>
													<select id="cityname" name="city" class="mys">
														@if(auth()->user())
														
																	<option  selected value="{{auth()->user()->city}}">{{auth()->user()->city}}</option>
														
													@endif
														@foreach(\App\Models\City::all(); as $city)
														<option>{{$city->name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>State*</label>
													<input required readonly type="text" id="state1" name="state" placeholder="State" value="{{auth()->user()?auth()->user()->state:''}}">
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 col-12 mb--20">
													<label>Zip Code*</label>
													<input required readonly type="text" name="zipcode" placeholder="Zip Code" id="zipcode"  value="{{auth()->user()?auth()->user()->zipcode:''}}">
												</div>
												@guest
												<div class="col-md-6 col-12 mb--20">
													<label>Password*</label>
													<input required type="password" name="password" placeholder="Password">
												</div>
												@endguest
											</div>
										</div>
									</div>
								</span>
							
							</div>
							<div class="col-lg-5">
								<div class="row">
									<!-- Cart Total -->
										<div class="order-note-block mt-5">
									<label for="order-note"><h5>Order Note</h5></label>
									<textarea required id="order-note" name="ordernote" cols="30" rows="10" class="order-note"
									placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
								</div>
									<div class="col-12" id="orderbill">
										
									</div>
									<div class="col-12">
										<button type='submit' class='place-order w-100'>Place order</button>
									</div>
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@include("sections.footer")
<script type="text/javascript">
	$(document).ready(function() {
		loadcart();
		bill();
	});
	$(document).on("submit","#userloginform",function(e) {
		e.preventDefault();
		email=$("#loginemail").val();
		pass=$("#loginpassword").val();
		$.ajax({
url:'checkinfo',
method:'post',
data:{email:email,pass:pass},
dataType:'json',
success:function(data)
{
if(data.output==0)
{
$("#loginerror").html("Email or Password is not Correct");
}
else
{
$("#loginerror").empty();
$("#formdata").html(data.output);
$("#checklogin").empty();
$("#quick-login").hide();
}


}
	});
	});
	function bill()
	{
		$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
url:'orderbill',
method:'post',
dataType:'text',
success:function(data) {
$("#orderbill").html(data);

}
});
	}
	$(document).on("change","#cityname",function(e){
e.preventDefault();
cityname=$("#cityname").val();
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
url:"cityinfo",
method:'post',
dataType:'json',
data:{cityname:cityname},
success:function(data)
{

$("#state1").val(data.a);
$("#zipcode").val(data.b);

}
});
});
</script>
@endsection