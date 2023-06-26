@extends('layouts.app')
@section('content')
<style>
.address{
width: 100%;
background-color: #f4f4f4;
border: 1px solid transparent;
border-radius: 0;
line-height: 23px;
padding: 10px 20px;
font-size: 14px;
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
                    <li class="breadcrumb-item active">My Account</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<div class="page-section inner-page-sec-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <!-- My Account Tab Menu Start -->
                    <div class="col-lg-3 col-12">
                        <div class="myaccount-tab-menu nav" role="tablist">
                            <a href="#dashboad" class="active" data-bs-toggle="tab"><i
                                class="fas fa-tachometer-alt"></i>
                            Dashboard</a>
                            <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>
                            <!-- <a href="#download" data-bs-toggle="tab"><i class="fas fa-download"></i> Download</a> -->
                            <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i>
                                Payment
                            Method</a>
                            <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i>
                            address</a>
                            <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Account
                            Details</a>
                            <a href="{{ route('logout') }}"onclick="event.preventDefault();
document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
@csrf
</form>
                        </div>
                    </div>
                    <!-- My Account Tab Menu End -->
                    <!-- My Account Tab Content Start -->
                    <div class="col-lg-9 col-12 mt--30 mt-lg--0">
                        <div class="tab-content" id="myaccountContent">
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Dashboard</h3>
                                    <div class="welcome mb-20">
                                        <p>Hello, <strong>{{$user->username}}</strong>
                                        </div>
                                        <p class="mb-0">From your account dashboard. you can easily check &amp; view
                                            your
                                            recent orders, manage your shipping and billing addresses and edit your
                                        password and account details.</p>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="orders" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Orders</h3>
                                        <div class="myaccount-table table-responsive text-center">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Order No#</th>
                                                        <th>Order Details</th>
                                                        <th>Date</th>
                                                        <th>Discount</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                        <th>Updated On</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($user->sales as $sale)
                                                    <tr>
                                                        <td>{{$sale->id}}</td>
                                                        <td>{!!$sale->saledata!!}</td>
                                                        <td>{{$sale->date}}</td>
                                                        <td>{{$sale->discount}}</td>
                                                        <td>{{$sale->total}}</td>
                                                        <td>{{$sale->details}}</td>
                                                        <td>{{$sale->updated_at->format("d-m-Y")}}</td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                              <!--   <div class="tab-pane fade" id="download" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Downloads</h3>
                                        <div class="myaccount-table table-responsive text-center">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Date</th>
                                                        <th>Expire</th>
                                                        <th>Download</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Mostarizing Oil</td>
                                                        <td>Aug 22, 2018</td>
                                                        <td>Yes</td>
                                                        <td><a href="#" class="btn">Download File</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Katopeno Altuni</td>
                                                        <td>Sep 12, 2018</td>
                                                        <td>Never</td>
                                                        <td><a href="#" class="btn">Download File</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                   <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Payment Method</h3>
                                        <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Billing Address</h3>
                                        <div id="msgdiv" class="my-2"></div>
                                        <form method="post" id="updateaddress">
                                            <address>
                                                <p>
                                                    <strong>{{$user->username}}</strong>
                                                </p>
                                                <p>
                                                    <input type="text" name="address1" class="address" value="{{$user->address1}}">
                                                    <br>
                                                    <input type="text" name="address2" class="address" value="{{$user->address2}}"></p>
                                                    <p><input type="text" name="phone" class="address" value="{{$user->phone}}"></p>
                                                </address>
                                                <button type="submit" class="btn btn--primary"><i class="fa fa-edit"></i>Edit
                                                Address</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Account Details</h3>
                                            <div class="account-details-form">
                                                <form method="post" id="updateaccount">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-12  mb--30">
                                                            <input id="first-name"value="{{$user->fname}}" placeholder="First Name"name="fname" type="text">
                                                            <div id="error-fname"></div>
                                                        </div>
                                                        <div class="col-lg-6 col-12  mb--30">
                                                            <input id="last-name" value="{{$user->lname}}" name="lname" placeholder="Last Name" type="text">
                                                            <div id="error-lname"></div>
                                                        </div>
                                                        <div class="col-12  mb--30">
                                                            <input id="email"value="{{$user->email}}" placeholder="Email Address" name="email" type="email" readonly>
                                                            <div id="error-email"></div>
                                                        </div>
                                                        <div class="col-12  mb--30">
                                                            <h4>Password change</h4>
                                                        </div>
                                                        <div class="col-12  mb--30">
                                                            <input id="current-pwd" name="current_pwd" placeholder="Current Password" type="password">
                                                            <div id="error-current_pwd"></div>
                                                        </div>
                                                        <div class="col-lg-6 col-12  mb--30">
                                                            <input id="new-pwd" placeholder="New Password" name="new_pwd" type="password">
                                                            <div id="error-new_pwd"></div>
                                                        </div>
                                                        <div class="col-lg-6 col-12  mb--30">
                                                            <input id="confirm-pwd" placeholder="Confirm Password" name="confirm_pwd" type="password">
                                                            <div id="error-confirm_pwd"></div> </div>
                                                            <div class="col-12">
                                                                <button type="submit" class="btn btn--primary">Save Changes</button>
                                                            </div>
                                                        </div>
                                                        <div id="mssgdiv" class="my-2"></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->
                                    </div>
                                </div>
                                <!-- My Account Tab Content End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include("sections.footer")
            <script>
            $(document).on("submit","#updateaccount",function(e) {
            e.preventDefault();
            $( "div[id*='error']" ).html("");
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
            url:"updateaccount",
            method:'post',
            dataType:'json',
            data:$("#updateaccount").serializeArray(),
            error: function (request, status, error)
            {
            
            if(request.responseJSON['errors'])
            {
            $.each(request.responseJSON['errors'],function(index,v){
            divid="error-"+index;
            $("#"+divid).addClass("text-danger").html(v);
            });}
            },
            success:function(data)
            {
            if(data.a==1)
            {
            
            $("#mssgdiv").html("Password updated please login again ").addClass("alert alert-success my-2");
            setTimeout(function(){
            window.location.href="/login";
            },1000);
            return;
            }
            $("#mssgdiv").fadeIn("slow").addClass("alert alert-success").html(data.a);
            setTimeout(function(){$("#mssgdiv").fadeOut('slow')},2000);
            
            },
            
            });
            });
            $(document).on("submit","#updateaddress",function(e) {
            e.preventDefault();
            
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
            url:"updateaddress",
            method:'post',
            dataType:'json',
            data:$("#updateaddress").serializeArray(),
            success:function(data)
            {
            
            
            
            $("#msgdiv").addClass("alert alert-success").html("Sucessfully Updated");
            setTimeout(function(){$("#msgdiv").fadeOut('slow').removeClass("alert alert-success")},2000);
            
            }
            });
            });
            
            
            </script>
            @endsection