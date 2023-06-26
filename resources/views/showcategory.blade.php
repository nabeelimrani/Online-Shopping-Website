@extends('layouts.app')
@section('content')
    <section class="breadcrumb-section">
            <h2 class="sr-only">Site Breadcrumb</h2>
            <div class="container">
                <div class="breadcrumb-contents">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Shop</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>
        <main class="inner-page-sec-padding-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 order-lg-2">
                        <div class="shop-toolbar with-sidebar mb--30">
                            <div class="row align-items-center">
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <!-- Product View Mode -->
                                    <div class="product-view-mode">
                                        <a href="#" class="sorting-btn active" data-target="grid"><i
                                                class="fas fa-th"></i></a>
                                        <a href="#" class="sorting-btn" data-target="grid-four">
                                            <span class="grid-four-icon">
                                                <i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i>
                                            </span>
                                        </a>
                                        <a href="#" class="sorting-btn" data-target="list "><i
                                                class="fas fa-list"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-6  mt--10 mt-sm--0">
                                   
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6  mt--10 mt-md--0">
                                   
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 mt--10 mt-md--0 ">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="shop-toolbar d-none">
                            <div class="row align-items-center">
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <!-- Product View Mode -->
                                    <div class="product-view-mode">
                                        <a href="#" class="sorting-btn active" data-target="grid"><i
                                                class="fas fa-th"></i></a>
                                        <a href="#" class="sorting-btn" data-target="grid-four">
                                            <span class="grid-four-icon">
                                                <i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i>
                                            </span>
                                        </a>
                                        <a href="#" class="sorting-btn" data-target="list "><i
                                                class="fas fa-list"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-md-4 col-sm-6  mt--10 mt-sm--0">
                                    
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6  mt--10 mt-md--0">
                                   
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mt--10 mt-md--0 ">
                                   
                                </div>
                            </div>
                        </div>
                                 <div class="shop-product-wrap grid with-pagination row space-db--30 shop-border ">
                           @if(!empty($products))
                            @foreach($products as $product)
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-card ">
                                    <div class="product-grid-content">
                                        <div class="product-header">
                                            <a href="#" class="author">
                                              {{$product->category->name}}
                                            </a>
                                            <h3><a href="product-details.html"> {{$product->name}}</a></h3>
                                        </div>
                                        <div class="product-card--body">
                                            <div class="card-image">
                                                <img src="{{'storage/'.$product->image}}" alt="">
                                                <div class="hover-contents">
                                                    <a href="product-details.html" class="hover-image">
                                                        <img src="{{'storage/'.$product->image}}" alt="">
                                                    </a>
                                                    <div class="hover-btns">
                                                  
                                                   
                                                  <form action="/compare" method="get">
                                        @csrf
                                        <input type="hidden" value="{{$product->id}}" name="pid">
                                        <button class="single-btn" type="submit"><i class="fas fa-random"></i></button>     
                                    </form>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#quickModal" data-id="{{$product->id}}"
                                        class="single-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="price-block">
                                                <span class="price">RS:{{$product->sprice}}</span>
                                            <!--     <del class="price-old">£51.20</del>
                                                <span class="price-discount">20%</span> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-list-content">
                                        <div class="card-image">
                                            <img src="{{'storage/'.$product->image}}" alt="">
                                        </div>
                                        <div class="product-card--body">
                                            <div class="product-header">
                                                <a href="#" class="author">
                                                     {{$product->category->name}}
                                                </a>
                                                <h3><a href="product-details.html" tabindex="0">{{$product->name}}</a></h3>
                                            </div>
                                            <article>
                                                <h2 class="sr-only">Card List Article</h2>
                                                <p>{!!$product->description!!}</p>
                                            </article>
                                            <div class="price-block">
                                                <span class="price">RS:{{$product->sprice}}</span>
                                             <!--    <del class="price-old">£51.20</del>
                                                <span class="price-discount">20%</span> -->
                                            </div>
                                     <!--        <div class="rating-block">
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star "></span>
                                            </div> -->
                                           <!--  <div class="btn-block">
                                                <a href="#" class="btn btn-outlined">Add To Cart</a>
                                                <a href="#" class="card-link"><i class="fas fa-heart"></i> Add To
                                                    Wishlist</a>
                                                <a href="#" class="card-link"><i class="fas fa-random"></i> Add To
                                                    Cart</a>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                       
                        <div class="row pt--30">
                            <div class="col-md-12">
                                
                            </div>
                        </div>
                            <div class="row pt--30">
                            <div class="col-md-12">
                                <div class="pagination-block">
                                    <ul class="pagination-btns flex-center">
                                        {{$products->links('pagination::bootstrap-4')}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Pagination Block -->
                   
                        <!-- Modal -->
                          </div>
                   <div class="col-lg-3  mt--40 mt-lg--0">
                        <div class="inner-page-sidebar">
                            <!-- Accordion -->
                            <div class="single-block">
                                <h3 class="sidebar-title">Categories</h3>
                                <ul class="sidebar-menu--shop">
                          @foreach(\App\Models\Category::all() as $index=>$category) 
                          <?php
$new="Online-".preg_replace("/[^a-zA-Z0-9]+/", "-", $category->name);
$new.="-Shopping-".$category->id;
?>
                      <li><a href="{{$new}}">{{$category->name}} ({{count($category->products)}})</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- Price -->
                       <!--      <div class="single-block">
                                <h3 class="sidebar-title">Fillter By Price</h3>
                                <div class="range-slider pt--30">
                                    <div class="sb-range-slider"></div>
                                    <div class="slider-price">
                                        <p> 
                                            <form action="/test">
                                            <input type="text" name="pricerange" id="amount" readonly="">
                                            <button>submit</button>
                                            </form>
                                        </p>
                                    </div>
                                </div>
                            </div> -->
                            <!-- Size -->
                        
                            <!-- Promotion Block -->
                            <div class="single-block">
                                <a href="#" class="promo-image sidebar">
                                    <img src="image/others/home-side-promo.jpg" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include("sections.modal")
                </div>
            </div>
        </main>
@include("sections.footer")
<script type="text/javascript">



</script>
@endsection