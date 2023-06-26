@extends('layouts.adminapp')
@section('content')

<div class="container" >
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered " id="entrytable">
                <thead>
                    
                    <th>Action</th>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Purchase</th>
                    <th>Sale</th>
                    <th>Inhand</th>
                    <th>Entry Date</th>
                    <th>Date Updated</th>
                    
                </thead>
                <tbody>
                    @foreach($products as $index=>$product)
                    <tr>
                        <td><div class="d-flex justify-content-between">
                        <i class="fa fa-trash mx-2 text-danger del" id="{{$product->id}}" role="button"></i>
                        <i class="fa fa-edit text-primary edit" id="{{$product->id}}"  role="button"></i>
                        </div></td>
                        <td>{{$product->id}}</td>
                        <td><img src="{{asset('storage/'.$product->image)}}" width="50"></td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->category->name}}</td>
                        <td>{!! substr($product->description,0,100) !!}</td>
                        <td>{{$product->pprice}}</td>
                        <td>{{$product->sprice}}</td>
                        <td>{{$product->inhand}}</td>
                        <td>{{$product->created_at}}</td>
                        <td>{{$product->updated_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="entrymodal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Product Entry</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="checkout-form">
            <form method="post" action="{{url('admin/enterproduct')}}"  enctype="multipart/form-data">
                                @csrf
                                <span id="formdata">
                                    <div id="billing-form" class="mb-40">
                                        <div class="row">
                                            <div class="col-md-12 col-12 mb--10">
                                                <label>Product Name*</label>
                                                <input required type="text" name="name" placeholder="Name">
                                            </div>
                                            <div class="col-md-12 col-12 mb--20">
                                                    <label>Category</label>
                                                    <select name="category_id" class="nice-select">
                                                        <option value="">Select Category</option>
                                                        @foreach(\App\Models\Category::all(); as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                            <div class="col-md-12 col-12 mb--20">
                                                <label>Description*</label>
                                           <textarea name="description" placeholder="Description" class="form-control"></textarea>
                                            </div>
                                            <div class="col-md-6 col-12 mb--20">
                                                <label>Purchase*</label>
                                                <input required type="text" name="pprice" placeholder="Purchase">
                                            </div>
                                                  <div class="col-md-6 col-12 mb--20">
                                                <label>shipping fee*</label>
                                                <input required type="text" id="sfee" placeholder="shipping Fee">
                                            </div>
                                                 
                                            <div class="col-md-6 col-12 mb--20">
                                                <label>Sale*</label>
                                                <input required type="text" id="saleprice" placeholder="Sale">
                                            </div>
                                                  <div class="col-md-6 col-12 mb--20">
                                                <label>total*</label>
                                                <input required type="text" id="sprice"name="sprice" placeholder="Total">
                                            </div>
                                       
                                                
                                                 <div class="col-12 mb--20">
                                               <label>image*</label>
                                                <input required type="file" name="image">
                                            </div>

                                              
                                        </div>
                                        <div class="col-md-10 mx-auto">
                                    <button type="submit" class="btn btn--primary">Submit</button>
                                </div>
                                    </div>
                                </span>
                                
                             </form>
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-bs-dismiss="modal" class="btn btn--primary">close</button>
      </div>
    </div>
  </div>
</div>
<!-- <'d-flex justify-content-between my-3'l<'my-2'fB>>t<'d-flex justify-content-between my-3'ip> -->
@include("sections.adminfooter")
<script type="text/javascript">

$(document).ready(function () {


    $("#sfee, #saleprice").on('keyup', function(){
     
      var n = Number($("#sfee").val());
var n2 = Number($("#saleprice").val());
var total = n + n2;
        console.log(n,n2,total)
        $("#sprice").val(total);
    });

$('#entrytable').DataTable({
"language":{
buttons: {
pdf: 'PDF',
},
},
"scrollY":400,
"scrollX":true,
"lengthMenu":[[50,100,-1],[50,100,"all"]],
"pageLength":50,
"dom":"<'d-flex justify-content-between my-2'<'my-1'l><'d-flex justify-content-end'fB>>t<'d-flex justify-content-between'<'my-3'i><'my-3'p>>",
buttons:[
{ extend: 'excel', className: 'btn  mx-2',footer: true },
{ extend: 'pdf', className: 'btn  mx-2',footer: true },
{ extend: 'print', className: 'btn  mx-2',footer: true },
{
"text":"Add Product",
className:'btn dt-button mx-2',
"action":function(){
$("#entrymodal").modal("show");
}
},
],
"initComplete": function() {
$('body').find('.dataTables_scrollBody').addClass("scrollbar");
$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
},
});
});
$(document).on("click",".del",function(e) {
    e.preventDefault();
    id=this.id;
    $.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
url:"/delproduct",
method:'post',
dataType:'json',
data:{id:id},
success:function(data)
{
    window.location.href="/admin/addproducts";
}
});
});
$(document).on("click",".edit",function(e) {
    e.preventDefault();
    id=this.id;
    $.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
url:"/editproduct",
method:'post',
dataType:'json',
data:{id:id},
success:function(data)
{

$("#formdata").html(data.a);
$("#entrymodal").modal('show');

}
});
    
});

</script>
@endsection