@extends('layouts.app')
@section('content')
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Product Details</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<main class="inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row  mb--60">
            <div class="col-lg-5 mb--30">
                <div class="img-fluid">
                    <img src="{{asset('storage/'.$product->image)}}" alt="" width="100%">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="product-details-info pl-lg--30 ">
                    
                    <h3 class="product-title">{{$product->name}}</h3>
                    <ul class="list-unstyled">
                        
                        <li>Product Category: <span class="list-value">{{$product->category->name}}</span></li>
                        <li>Product Code: <span class="list-value">{{$product->id}}</span></li>
                        <li>Availability: <span class="list-value">{{$product->inhand>0?'In Stock':'Out of Stock'}}</span></li>
                    </ul>
                    <div class="price-block">
                        <span class="price-new">RS:-{{$product->sprice}}</span>
                        <!-- <del class="price-old">£91.86</del> -->
                    </div>
                    <div class="rating-widget">
                              <div class="rating-block">
                                      @if($product->ratings->count() > 0)
                                <ul>
                                    
                                    <li>
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($product->ratings->avg('rating')))
                                            <span class="ion-android-star-outline star_on"></span>
                                            @else
                                            <span class="ion-android-star-outline"></span>
                                            @endif
                                            @endfor
                                        </div>
                                    </li>
                                    
                                </ul>
                                @else
                                <p>No ratings found.</p>
                                @endif
                        </div>
                        
                        <div class="review-widget w-100 mt-3">
                            <a href="#">({{$product->rcountt}} Reviews)</a>                             
                        </div>
                    </div>
                      <form method="post" id="addtocart1">
                                     
                                    <div class="add-to-cart-row">
                                       <input type="hidden" id="pid" value="{{$product->id}}">
                                        <div class="count-input-block">
                                            <span class="widget-label">Qty</span>
                                            <input type="number" class="form-control text-center" value="1" id="pqty">
                                        </div>
                                        <div class="add-cart-btn">
                                            <button type="submit" class="btn btn-outlined--primary"><span
                                                    class="plus-icon">+</span>Add to Cart</button>
                                        </div>
                                        
                                    </div>
                                    </form>
                <div class="compare-wishlist-row my-4">
                    
                       <form action="/compare" method="get">
                                        @csrf
                                        <input type="hidden" value="{{$product->id}}" name="pid">
                                        <button class="single-btn" type="submit"><i class="fas fa-random"></i></button>     
                                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="sb-custom-tab review-tab section-padding">
        <ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#tab-1" role="tab"
                    aria-controls="tab-1" aria-selected="true">
                    DESCRIPTION
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#tab-2" role="tab"
                    aria-controls="tab-2" aria-selected="true">
                    REVIEWS ({{$product->rcountt}})
                </a>
            </li>
        </ul>
        <div class="tab-content space-db--20" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab1">
                <article class="review-article">
                    <h1 class="sr-only">Tab Article</h1>
                    <p>{!! $product->description!!}</p>
                </article>
            </div>
            <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab2">
                <div class="review-wrapper">
                    <h2 class="title-lg mb--20">{{$product->rcountt}} REVIEW FOR {{$product->name}}</h2>
                    @foreach($product->ratings as $rating)
                    <div class="review-comment mb--20">
                        
                        <div class="text">
                            <div class="rating-block mb--15">
                                @if($rating->count() > 0)
                                <ul>
                                    
                                    <li>
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $rating->rating)
                                            <span class="ion-android-star-outline star_on"></span>
                                            @else
                                            <span class="ion-android-star-outline"></span>
                                            @endif
                                            @endfor
                                        </div>
                                    </li>
                                    
                                </ul>
                                @else
                                <p>No ratings found.</p>
                                @endif
                            </div>
                            <h6 class="author">{{$rating->user->username}} – <span class="font-weight-400">{{$rating->created_at->format('d-m-Y')}}</span>
                            </h6>
                            <p>{{$rating->comment}}</p>
                        </div>
                    </div>
                    @endforeach
                            @auth
                    <h2 class="title-lg mb--20 pt--15">ADD A REVIEW</h2>
                    <div class="rating-row pt-2">
                       
                        <form method="POST" action="{{ route('ratings.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="rating">Rating:</label>
                                <select name="rating" id="rating" class="form-control">
                                    <option value="1">1 star</option>
                                    <option value="2">2 stars</option>
                                    <option value="3">3 stars</option>
                                    <option value="4">4 stars</option>
                                    <option value="5">5 stars</option>
                                </select>
                            </div>
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                          
                       
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                            @error('comment')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                            @enderror
                                        <textarea name="comment" id="comment" cols="15" rows="2"
                                        class="form-control"></textarea>
                                    </div>
                               
                                    </div>
                                      <button type="submit" class="btn btn-primary">Submit</button>
                  
                                          </form>
                                          @endauth
                                </div>
                            </div>
                   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=================================
RELATED PRODUCTS BOOKS
===================================== -->
<section class="">
    <div class="container">
        <div class="section-title section-title--bordered">
            <h2>RELATED PRODUCTS</h2>
        </div>
        <div class="product-slider sb-slick-slider slider-border-single-row" data-slick-setting='{
            "autoplay": true,
            "autoplaySpeed": 8000,
            "slidesToShow": 4,
            "dots":true
            }' data-slick-responsive='[
            {"breakpoint":1200, "settings": {"slidesToShow": 4} },
            {"breakpoint":992, "settings": {"slidesToShow": 3} },
            {"breakpoint":768, "settings": {"slidesToShow": 2} },
            {"breakpoint":480, "settings": {"slidesToShow": 1} }
            ]'>
           @foreach($relatedpro as $pro)
            <div class="single-slide">
                <div class="product-card">
                     <div class="product-header">
                        <a href="#" class="author">
                            {{$pro->category->name}}
                        </a>
                        <h3><a href="/singleproduct/{{$pro->id}}">{{$pro->name}}</a></h3>
                    </div>
               
                        <div class="product-card--body">
                        <div class="card-image">
                            <img src="{{asset('storage/'.$pro->image)}}">
                            <div class="hover-contents">
                                <a href="/singleproduct/{{$pro->id}}" class="hover-image">
                                    <img src="{{asset('storage/'.$pro->image)}}" class="img-thumbnail rounded mx-auto d-block">
                                </a>
                                <div class="hover-btns">
   <!--                               <form class="directcart-form">
    <input type="hidden" name="id" value="{{$pro->id}}">
    <input type="hidden" name="qty" value="1">
    <button type="submit" class="single-btn">
        <i class="fas fa-shopping-basket"></i>
    </button>
</form> -->
                                    <!--   <a href="wishlist.html" class="single-btn">
                                    <i class="fas fa-heart"></i> </a> -->
                                    
                                    <form action="/compare" method="get">
                                        @csrf
                                        <input type="hidden" value="{{$pro->id}}" name="pid">
                                        <button class="single-btn" type="submit"><i class="fas fa-random"></i></button>
                                    </form>
                                 <!--    <a href="#" data-bs-toggle="modal" data-bs-target="#quickModal" data-id="{{$pro->id}}"
                                        class="single-btn">
                                        <i class="fas fa-eye"></i>
                                    </a> -->
                                </div>
                            </div>
                        </div>
                        <div class="price-block">
                            <span class="price text-black-50">RS {{$pro->sprice}}</span>
                            <!-- <del class="price-old">{{$product->pprice+$product->sprice*52/100}}</del> -->
                            <!-- <span class="price-discount">50%</span> -->
                                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @include("sections.modal")
</section>
@include("sections.footer")
<script type="text/javascript">
  
   $(document).on("submit","#addtocart1",function(event){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
                event.preventDefault();
   $.post( "/additem", { id:$("#pid").val() , qty: $("#pqty").val() })
  .done(function( data ) {
    window.location.href="/";
  });
    });


</script>
@endsection