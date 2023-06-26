@extends('layouts.adminapp')
@section('content')

<div class="container" >
    <div class="row">
        <div class="col-md-12">
            <div class="table-resposive">
                  <table class="table table-bordered " id="entrytable">
                <thead>
                        <th></th>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Vendor Name</th>
                        <th>Voucher #</th>
                        <th>Detail</th>
                        <th>Amount</th>
                </thead>
                <tbody>
                @foreach($stocks as $stock)
               <tr>
                   <td>
                    <div class="d-flex justify-content-center">
                    <i class="fa fa-trash text-danger del" id="{{$stock->id}}" role="button"></i>
                    <a href="/editstock/{{$stock->id}}"class="fa fa-edit text-success mx-2"  role="button" ></a>
                    </div>
             </td>
               
                   <td>{{$stock->id}}</td>
                   <td>{{$stock->created_at->format('Y-m-d')}}</td>
                   <td>{{$stock->vendor->name}}</td>
                   <td>{{$stock->vno}}</td>
                   <td>{!!$stock->detail!!}</td>
                   <td>{{$stock->amount}}</td>
               </tr>
               @endforeach
                </tbody>
            </table>        
            </div>
        </div>
    </div>
</div>
<!-- <'d-flex justify-content-between my-3'l<'my-2'fB>>t<'d-flex justify-content-between my-3'ip> -->
@include("sections.adminfooter")
<script type="text/javascript">

$(document).ready(function () {

$('#entrytable').DataTable({
"language":{
buttons: {
pdf: 'PDF',
},
},
"scrollY":400,
// "scrollX":true,
"lengthMenu":[[50,100,-1],[50,100,"all"]],
"pageLength":50,
"dom":"<'d-flex justify-content-between my-2'<'my-1'l><'d-flex justify-content-end'fB>>t<'d-flex justify-content-between'<'my-3'i><'my-3'p>>",
buttons:[
{ extend: 'excel', className: 'btn  mx-2',footer: true },
{ extend: 'pdf', className: 'btn  mx-2',footer: true },
{ extend: 'print', className: 'btn  mx-2',footer: true },
{
"text":"Add STock",
className:'btn dt-button mx-2',
"action":function(){
    location.href="/addstock";
}
},
],
"initComplete": function() {
// $('body').find('.dataTables_scrollBody').addClass("scrollbar");
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
    swal({
    title: 'Are you sure?',
    text: 'Once deleted, you will not be able to recover this',
    icon: 'warning',
    buttons: true,
    dangerMode: true,
  })
    .then((willDelete) => {
      if (willDelete){
$.ajax({
url:"/delstock",
method:'post',
dataType:'json',
data:{id:id},
success:function(data)
{
    window.location.href="/stock";
}
});
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
url:"/editstock",
method:'post',
dataType:'json',
data:{id:id},
success:function(data)
{




}
});
    
});

</script>
@endsection