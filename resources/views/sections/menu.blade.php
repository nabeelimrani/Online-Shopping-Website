<div class="site-wrapper" id="top">
    <div class="site-header">
        <div class="header-middle pt--10 pb--10">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3 col-sm-3 ">
                    <a href="/"><h1 class="text-primary font-weight-bold">OnlineShop</h1></a> 
                    <!--     <a href="index.html" class="site-brand">
                            <img src="image/logo.png" alt="">
                        </a> -->
                    </div>
                    <div class="col-md-3 col-sm-3 ">
                        <div class="header-phone ">
                            <div class="icon">
                                <i class="fas fa-headphones-alt"></i>
                            </div>
                            <div class="text">
                                <p>Free Support 24/7</p>
                                <p class="font-weight-bold number">+01-202-555-0181</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 ">
                        <div class="main-navigation flex-lg-right">
                            <ul class="main-menu menu-right ">
                                 <li class="menu-item">
                    <a href="{{url('/')}}">Home</a>
                </li>

                <li class="menu-item">
                    <a href="contact.html">Contact</a>
                </li>
                        
                        @guest
 <!-- <li class="menu-item"><a href="{{route('register')}}">Register</a></li> -->
 <li class="menu-item"><a href="{{route('login')}}">Login</a></li>


                        @else 
                         <li class="menu-item"><a href="{{route('profile')}}">Profile</a></li>  
                <!-- Pages -->
                <li class="menu-item has-children">
                    <a href="javascript:void(0)">{{auth()->user()->fname." ".auth()->user()->lname}} <i
                    class="fas fa-chevron-down dropdown-arrow"></i></a>
                    <ul class="sub-menu">
                        <li>
                             <a class="font-weight-bold" href="{{ route('logout') }}"
onclick="event.preventDefault();
document.getElementById('logout-form').submit();"> Logout</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
@csrf
</form>
                        </li>
                        
                    </ul>
                </li>
                @endguest
                <!-- Blog -->
              
                
            </ul>
        </div>
    </div>
</div>
</div>
</div>
<div class="header-bottom pb--10">
<div class="container">
<div class="row align-items-center">
    <div class="col-md-3 col-sm-3 ">
        <nav class="category-nav  ">
            <div>
                <a href="javascript:void(0)" class="category-trigger"><i
                    class="fa fa-bars"></i>Browse
                categories</a>
                <ul class="category-menu">
@foreach(\App\Models\Category::all() as $index=>$category) 
<?php
$new="Online-".preg_replace("/[^a-zA-Z0-9]+/", "-", $category->name);
$new.="-Shopping-".$category->id;
?>
@if($index<=5)      
<li class="cat-item "><a href="{{$new}}">{{$category->name}}</a></li>
@else
<li class="cat-item hidden-menu-item"><a href="{{$new}}">{{$category->name}}</a></li>
@endif      
@endforeach




<li class="cat-item"><a href="#" class="js-expand-hidden-menu">More
Categories</a></li>
</ul>
</div>
</nav>
</div>
<div class="col-md-5 col-sm-5 ">
<div class="header-search-block">
    <form action="{{route('search')}}" method="post">
        @csrf
<input type="text" name="find" placeholder="Search entire store here">
<button type="submit">Search</button>
</form>
</div>
</div>
<div class="col-md-4">
<div class="main-navigation flex-lg-right">
<div class="cart-widget">
<div class="login-block">

</div>
<div class="cart-block">
<div class="cart-total">
<span class="text-number" id="totalitem">
</span>
<span class="text-item">
    Shopping Cart
</span>
<span class="price" id="totalprice">
    0.00 PKR
    <i class="fas fa-chevron-down"></i>
</span>
</div>
<div class="cart-dropdown-block">
<div class=" single-cart-block" id="cartbox">
   
</div>
<div class=" single-cart-block ">
    <div class="btn-block">
               <a href="{{url('cart')}}" class="btn btn--primary">View Cart<i
        class="fas fa-chevron-right"></i></a>    
               <a href="{{url('checkout')}}" class="btn">Checkout<i
        class="fas fa-chevron-right"></i></a>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


