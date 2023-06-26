@extends('layouts.app')
@section('content')
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Compare</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<!-- Cart Page Start -->
<main class="compare_area inner-page-sec-padding-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 my-3">
                        <a href="/" class="btn btn--primary mx-auto">Select another Product</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <form action="#">
                            <!-- Compare Table -->
                            <div class="compare-table table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="first-column">Product</td>
                                            @foreach($products as $product)
                                            <td class="product-image-title">
                                                <a href="#" class="image"><img src="{{asset('storage/'.$product->image)}}"
                                                        alt="Compare Product"></a>
                                                <a href="#" class="category">{{$product->category->name}}</a>
                                                <a href="#" class="title">{{$product->name}}</a>
                                            </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="first-column">Description</td>
                                                @foreach($products as $product)
                                            <td class="pro-desc">
                                                <p>{{$product->description}}</p>
                                            </td>
                                          @endforeach
                                        </tr>
                                        <tr>
                                            <td class="first-column">Price</td>
                                                @foreach($products as $product)
                                            <td class="pro-price">Rs:-{{$product->sprice}}</td>
                                            @endforeach
                                        </tr>
                                     
                                        <tr>
                                            <td class="first-column">Stock</td>

                                           
                                          @foreach($products as $product)
                                           <td class="pro-stock">{{$product->inhand>0?"In Stock":"Out of stock"}}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="first-column">Add to cart</td>
                                                @foreach($products as $product)
                                            <td class="pro-addtocart">

                                                <a href="#" id="{{$product->id}}" class="add-to-cart"><i
                                                        class="fas fa-shopping-cart"></i><span>ADD TO CART</span></a>
                                            </td>
                                                @endforeach
                                        </tr>
                                        <tr>
                                            <td class="first-column">Delete</td>
                                            @foreach($products as $index=>$product)
                                            <td class="pro-remove"><a id="{{$index}}" class="removecompare"><i class="fas fa-trash"></i></a></td>
                                         
                                            @endforeach
                                        </tr>
                                             <tr>
                                    <td class="first-column">Rating</td>
                                 <!--    @foreach($products as $product)
                                    <td class="pro-rating">
                                        @if($product->rating > 0)
                                        @for($i = 0; $i < $product->rating; $i++)
                                        <i class="fa fa-star"></i>
                                        @endfor
                                        @endif
                                    </td>
                                    @endforeach -->
                                </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
@include("sections.footer")
<script type="text/javascript">

$(document).on("ready",function(){
loadcart();
});

$(document).on("click",".add-to-cart",function(e)
{
e.preventDefault();
    id=this.id;
    qty=1;
   
    
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
   $.ajax({
            url:"additem",
            method:'post',
            data:{id:id,qty:qty},
            dataType:'json',
            success:function(data)
            {
                    loadcart();
                  
            }
        });

});

$(document).on("click",".removecompare",function(e)
{
e.preventDefault();
    id=this.id;
   
   
    
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
   $.ajax({
            url:"removecompare",
            method:'post',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
         
                 window.location.href="/compare";
            }
        });

});

</script>
@endsection