@extends('layouts.adminapp')
@section('content')

<div class="container" >
    <div class="row">
        <div class="col-md-12">
            <div class="table-resposive">
                  <table class="table table-bordered " id="entrytable">
               <thead>
                    <tr>
                  
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Purchase</th>
                    <th>Sale</th>
                    <th>Current Stock</th>
                    
                   
                </tr>
                    
                </thead>
                <tbody>
                                @foreach($products as $product)
                     <tr>
                       
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->stocks->sum("pivot.quantity")}}</td>
                        <td>{{$product->sales->sum("pivot.quantity")}}</td>
                        
                        <td>{{$product->inhand}}</td>
                        
                       
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
"text":"Add payment",
className:'btn dt-button mx-2',
"action":function(){
    $("#addpayment").modal("show");
}
},
],
"initComplete": function() {
// $('body').find('.dataTables_scrollBody').addClass("scrollbar");
$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
},


// footerCallback: function ( row, data, start, end, display ) {
         
        
//             var api = this.api(),data;
//             console.log(api);
            
//             // Remove the formatting to get integer data for summation
//             var intVal = function ( i ) {
//                 return typeof i === 'string' ?
//                     i.replace(/[\$,]/g, '')*1 :
//                     typeof i === 'number' ?
//                         i : 0;
//             };
            
//             function numberWithCommas(x) {
//     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
// }
            
            
//             var total = api
//                 .column(5, { page: 'end'} )
//                 .data()
//                 .reduce( function (a, b) {
//                     return intVal(a) + intVal(b);
//                         }, 0);
                  
                       
//         $( api.column(5).footer() ).html("Rs "+numberWithCommas(total));
        
       
// },

});
});









</script>
@endsection