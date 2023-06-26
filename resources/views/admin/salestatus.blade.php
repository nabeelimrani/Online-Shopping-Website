@extends('layouts.adminapp')
@section('content')
<!-- Cart Page Start -->
<main id="content" class="page-section inner-page-sec-padding-bottom space-db--20">
    <div class="container table-responsive">
        
        <div class="row">
            <div class="col-md-12  mx-auto">
                <div class="card shadow">
                    <div class="card-body">
                        
                        <table class="table table-bordered" id="producttable" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Order Detail</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Upated ON</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                  <td>{!! $order->info!!}</td>
                                    <td>{{$order->created_at->format("d-m-Y")}}</td>
                                    <td>{{$order->total}}</td>
                                 <td>{!! $order->details !!}</td>
                                    <td>{{$order->updated_at->format("d-m-Y")}}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            
        </div>
        <div class="row mt-5">
            <div id="output"></div>
        </div>
        <div class="d-flex justify-content-center" id="success">
            
        </div>
    </main>
    
    
    <!-- Cart Page End -->
</div>
@include("sections.adminfooter")
<script>
$(document).ready(function () {
$('#producttable').DataTable({
"language":{

buttons: {
pdf: 'PDF',

},

}   ,
"scrollY":500,
"scrollX":true,
"pageLength":50,
"sort":false,
"bsort":false,
"lengthMenu":[[50,100,200,-1],[50,100,200,"All"]],

dom: "<'d-flex justify-content-between my-3'<'mb-y'l><'text-right'<'d-flex justify-content-end'fB>>>t<'d-flex justify-content-between'<'my-3'i><'my-3'p>>",
"lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
buttons:[
{ extend: 'print', className: 'btn  mx-2',footer: true },
{ extend: 'excel', className: 'btn',footer: true },
{ extend: 'pdf', className: 'btn' ,footer: true},

],
"initComplete": function() {
$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
},
});

});
</script>
@endsection