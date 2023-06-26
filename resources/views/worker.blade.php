@extends($layout)
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-4 shadow">
              <div class="row my-3">
     
    </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="updateopform">
                        <div class='input-group'>
                            <input type="text" placeholder="search order" id="orderid" class="form-control"><button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-5 ">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body" id="orderdata">
                    
                </div>
            </div>
               <div class="" id="success"></div>
        </div>
    </div>
  
</div>
@include("sections.workerfooter")
<script type="text/javascript">
$(document).ready(function() {

$("#updateopform").submit(function(e) {
e.preventDefault();

$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
url:"updateorderstatus",
method:'post',
dataType:'json',
data:{status:$("#orderid").val()},
success:function(data)
{

$("#orderdata").html(data.a);
},
});
});
$(document).on("change","#status",function() {
    $.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
url:"changestatus",
method:'post',
dataType:'json',
data:{status:$("#status").val(),id:$("#orderid").val()},
success:function(data)
{
    $("#success").addClass("alert alert-success").html("Sucessfully Updated");
     setTimeout(function(){$("#success").html("").removeClass("alert alert-success")},2000);
},
});
});
});

</script>
@endsection