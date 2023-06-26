@extends('layouts.adminapp')
@section('content')
<style>
.bar {
border-right:5px inset #ddd;
}
.topbar {
border-bottom:5px inset #ddd;
}
</style>
<div class="container" >
    <div class="row mt-5">
        <form method="POST" id="stockform">
            <div class="row topbar pb-3">
                <div class="col-md-4">

                    <input required tye=text id="date" name="date" class="form-control datepicker" autocomplete="off" value="{{$hdata['date']}}">
                    <input required type="hidden" id="stockid" name="stockid" value="{{$stockid}}">
                </div>
                <div class="col-md-4">
                    <input required type="text" name="vno" class="form-control" placeholder="voucher#" value="{{$hdata['vno']}}">
                </div>
                <div class="col-md-4">
                    <input required type="text" class="form-control" name="vendor" value="{{$hdata['vendor']}}" autocomplete="off" placeholder="vendor" list="vendors">
                    <datalist id="vendors">
                    @foreach($vendors as $vendor)
                    <option>{{$vendor->name}}</option>
                    @endforeach
                    </datalist>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 bar">
                    <div class="my-3">
                        <select required name="product_id" id="product_id" class="form-control">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>   
                    </div>
                    <div class="mb-3">
                        <input required type=text name="quantity" id="quantity" class="form-control " placeholder="Quantity">
                    </div>
                    <div class="mb-3">
                        <input required type=text name="price" id="price" class="form-control" placeholder="Price">
                    </div>
                    <div class="mb-3">
                        <button type=submit class="btn btn-primary">{{$stockid>0?'Update Item':'add Item'}}</button>
                    </div>
                </div>
                   </form>  
                <div class="col-md-8">
                    <div id="output" class="mx-auto">{!!$output!!}</div>
                    <div class="d-flex justify-content-center ">
                        <button class="btn btn-dark d-none" id="storestock">{{$stockid>0?'Update Stock':'add stock'}}</button>
                    </div>
                </div>
            </div>
        </div>
 

<div class="col-md-6"></div>
</div>
</div>
@include("sections.adminfooter")
<script type="text/javascript">



$(document).on("click","#storestock",function(e){
e.preventDefault();
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
url:"/storestock",
method:'post',
dataType:'json',
data:{stockid:$("#stockid").val()},
success:function(data)
{
        window.location.href="/stock";
}
});
});



$(document).on("click",".remove",function(e){
e.preventDefault();
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
url:"/removestock",
method:'post',
dataType:'json',
data:{index:this.id},
success:function(data)
{

$("#storestock").removeClass("d-none");
$("#output").html(data.a);

}
});
    
});


$(document).on("submit","#stockform",function(e){
e.preventDefault();
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
url:"/enterstock",
method:'post',
dataType:'json',
data:$("#stockform").serializeArray(),
success:function(data)
{
$("#output").html(data.a);
$("#storestock").removeClass("d-none");
$("#product_id").val("");
$("#quantity").val("");
$("#price").val("");
}
});
});






</script>
@endsection