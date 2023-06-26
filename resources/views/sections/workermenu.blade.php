<div class="site-wrapper" id="top">
    <div class="site-header d-none d-lg-block">
        <div class="header-middle pt--10 pb--10">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 ">
                      <a href="/"><h1 class="text-primary font-weight-bold">OnlineShop</h1></a> 
                    </div>
                    <div class="col-lg-3">
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
                    <div class="col-lg-6">
                        <div class="main-navigation flex-lg-right">
                            <ul class="main-menu menu-right ">
                                 <li class="menu-item">
                    <a href="{{url('/')}}">Website</a>
                    <a href="{{url('/viewoperatorpage')}}">Home</a>
                </li>

                
                     
                      
                <!-- Pages -->
                <li class="menu-item has-children">
                    <a href="javascript:void(0)">{{auth()->user()->fname}}<i
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
           
                <!-- Blog -->
              
                
            </ul>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
